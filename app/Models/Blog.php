<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'author_id',
        'author_name',
        'featured_image',
        'category',
        'tags',
        'is_published',
        'is_featured',
        'views',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            
            if (empty($blog->published_at) && $blog->is_published) {
                $blog->published_at = now();
            }
            
            if (empty($blog->author_id) && auth()->check()) {
                $blog->author_id = auth()->id();
            }
            
            if (empty($blog->author_name) && auth()->check()) {
                $blog->author_name = auth()->user()->name;
            }
        });

        static::updating(function ($blog) {
            if ($blog->is_published && empty($blog->published_at)) {
                $blog->published_at = now();
            }
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where(function ($q) {
                        $q->whereNull('published_at')
                          ->orWhere('published_at', '<=', Carbon::now());
                    });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('published_at', 'desc')
                    ->limit($limit);
    }

    public function getUrlAttribute()
    {
        return route('blogs.show', $this->slug);
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        
        return asset('images/default-blog-image.jpg');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->format('F d, Y') : null;
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200); // 200 words per minute
        
        return max(1, $minutes);
    }
}