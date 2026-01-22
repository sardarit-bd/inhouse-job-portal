<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Job extends Model
{
    use HasFactory;

    // ✅ Specify the custom table name
    protected $table = 'open_jobs';

    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'description',
        'company_name',
        'company_logo',
        'location',
        'salary',
        'salary_min',
        'salary_max',
        'salary_type',
        'salary_currency',
        'job_type',
        'experience_level',
        'skills_required',
        'benefits',
        'application_deadline',
        'is_active',
        'status',
        'views',
        'category_id',
        'company_id',
        'is_negotiable',
    ];

    protected $casts = [
        'skills_required' => 'array',
        'benefits' => 'array',
        'application_deadline' => 'date',
        'is_active' => 'boolean',
        'is_negotiable' => 'boolean',
        'views' => 'integer',
        // Remove decimal casting as it causes issues with null values
        // 'salary_min' => 'decimal:2', // ❌ Remove this
        // 'salary_max' => 'decimal:2', // ❌ Remove this
    ];

    // ✅ Boot method to generate slug
    // app/Models/Job.php

// ✅ Generate slug with uniqueness check (public method)
public function generateSlug()
{
    $slug = Str::slug($this->title);
    $originalSlug = $slug;
    $count = 1;

    while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
        $slug = $originalSlug . '-' . $count++;
    }

    return $slug;
}

    // ✅ Generate unique slug
    public function generateUniqueSlug()
    {
        $slug = Str::slug($this->title);
        $originalSlug = $slug;
        $count = 1;

        // Check if slug exists
        while (static::where('slug', $slug)->where('id', '!=', $this->id ?? null)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    // ✅ Get route key name for URL
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // ✅ Find by ID or Slug
    public static function findBySlugOrId($identifier)
    {
        if (is_numeric($identifier)) {
            return static::find($identifier);
        }
        return static::where('slug', $identifier)->first();
    }

    // ✅ Custom accessor for salary field
    public function getSalaryAttribute($value)
    {
        // If value is "Negotiable" or other string, return as is
        if (!is_numeric($value)) {
            return $value;
        }
        
        // If it's numeric, format with 2 decimal places
        return number_format((float)$value, 2, '.', '');
    }

    // ✅ Custom mutator for salary field
    public function setSalaryAttribute($value)
    {
        // If value is "Negotiable" or empty string, store as is
        if ($value === 'Negotiable' || $value === '' || $value === null) {
            $this->attributes['salary'] = $value;
        } 
        // If it's numeric, store as numeric
        elseif (is_numeric($value)) {
            $this->attributes['salary'] = (float)$value;
        }
        // Otherwise store as string
        else {
            $this->attributes['salary'] = $value;
        }
    }

    // ✅ Custom accessor for salary_min
    public function getSalaryMinAttribute($value)
    {
        if ($value === null) {
            return null;
        }
        return (float)$value;
    }

    // ✅ Custom mutator for salary_min
    public function setSalaryMinAttribute($value)
    {
        if ($value === '' || $value === null) {
            $this->attributes['salary_min'] = null;
        } else {
            $this->attributes['salary_min'] = (float)$value;
        }
    }

    // ✅ Custom accessor for salary_max
    public function getSalaryMaxAttribute($value)
    {
        if ($value === null) {
            return null;
        }
        return (float)$value;
    }

    // ✅ Custom mutator for salary_max
    public function setSalaryMaxAttribute($value)
    {
        if ($value === '' || $value === null) {
            $this->attributes['salary_max'] = null;
        } else {
            $this->attributes['salary_max'] = (float)$value;
        }
    }

    // ✅ Formatted salary display
    public function getFormattedSalaryAttribute()
    {
        if ($this->salary_min && $this->salary_max) {
            $salary = '$' . number_format($this->salary_min, 0) . ' - $' . number_format($this->salary_max, 0);
        } elseif ($this->salary_min) {
            $salary = 'From $' . number_format($this->salary_min, 0);
        } elseif ($this->salary_max) {
            $salary = 'Up to $' . number_format($this->salary_max, 0);
        } elseif ($this->salary) {
            // Use the old salary field as fallback
            if (is_numeric($this->salary)) {
                $salary = '$' . number_format((float)$this->salary, 0);
            } else {
                $salary = $this->salary;
            }
        } else {
            $salary = 'Negotiable';
        }

        if ($this->salary_type && !$this->is_negotiable) {
            $salary .= ' per ' . $this->salary_type;
        }

        if ($this->is_negotiable) {
            $salary .= ' (Negotiable)';
        }

        return $salary;
    }

    // ✅ Check if job is expired
    public function getIsExpiredAttribute()
    {
        if (!$this->application_deadline) {
            return false;
        }
        return now()->gt($this->application_deadline);
    }

    // ✅ Check if job is active and approved
    public function getIsAvailableAttribute()
    {
        return $this->is_active && $this->status === 'approved' && !$this->is_expired;
    }

    // ✅ Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }

    public function views(): HasMany
    {
        return $this->hasMany(JobView::class, 'job_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // ✅ Increment view with IP tracking
    public function incrementView($ipAddress)
    {
        // Check if IP already viewed today
        $today = now()->format('Y-m-d');
        $existingView = $this->views()
            ->where('ip_address', $ipAddress)
            ->whereDate('viewed_at', $today)
            ->first();

        if (!$existingView) {
            $this->views()->create([
                'ip_address' => $ipAddress,
                'viewed_at' => now()
            ]);
            
            $this->increment('views');
        }
    }

    // ✅ Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeExpired($query)
    {
        return $query->whereDate('application_deadline', '<', now());
    }

    // ✅ Application methods
    public function hasUserApplied($userId = null)
    {
        if (!$userId && auth()->check()) {
            $userId = auth()->id();
        }

        if (!$userId) {
            return false;
        }

        return $this->applications()
            ->where('user_id', $userId)
            ->exists();
    }

    // ✅ Get application by user
    public function getUserApplication($userId = null)
    {
        if (!$userId && auth()->check()) {
            $userId = auth()->id();
        }

        if (!$userId) {
            return null;
        }

        return $this->applications()
            ->where('user_id', $userId)
            ->first();
    }

    public function getSlugOrIdAttribute()
    {
        return $this->slug ?: $this->id;
    }

    public function getJobUrlAttribute()
    {
        return route('jobs.show', $this->slug ?: $this->id);
    }
}