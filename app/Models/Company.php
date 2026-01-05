<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'logo',
        'description',
        'industry',
        'location',
        'size',
        'founded_date',
        'is_active',
    ];

    protected $casts = [
        'founded_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function jobs()
    {
        return $this->hasMany(OpenJob::class, 'company_name', 'name');
    }
}