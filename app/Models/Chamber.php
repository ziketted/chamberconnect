<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chamber extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo_path',
        'cover_image_path',
        'location',
        'address',
        'website',
        'email',
        'phone',
        'verified',
        'social_links',
        'description',
        'type',
        'embassy_country',
        'embassy_address',
        'state_number',
        'certification_date',
        'certification_notes',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'social_links' => 'array',
        'certification_date' => 'date',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role', 'status')
            ->withTimestamps();
    }

    public function approvedMembers(): BelongsToMany
    {
        return $this->members()->wherePivot('status', 'approved');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function forums(): HasMany
    {
        return $this->hasMany(Forum::class);
    }
}
