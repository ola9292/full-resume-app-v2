<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Resume extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'role',
        'location',
        'email',
        'phone',
        'website',
        'summary',
        'education',
        'job_experience',
        'skills',
    ];

    protected $casts = [
        'education' => 'array',
        'job_experience' => 'array',
        'skills' => 'array',
    ];

    //  public function about_sections(): HasOne
    // {
    //     return $this->HasOne(About::class);
    // }
    //  public function educations(): HasMany
    // {
    //     return $this->HasMany(Education::class);
    // }
    //  public function experience(): HasMany
    // {
    //     return $this->HasMany(Experience::class);
    // }
}
