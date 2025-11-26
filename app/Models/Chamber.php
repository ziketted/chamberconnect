<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chamber extends Model
{
    use HasFactory, SoftDeletes;

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
        'is_suspended',
        'suspended_at',
        'suspension_reason',
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
        'is_suspended' => 'boolean',
        'suspended_at' => 'datetime',
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
            ->withPivot('role', 'status', 'position')
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

    /**
     * Scope pour les chambres actives (non suspendues)
     */
    public function scopeActive($query)
    {
        return $query->where('is_suspended', false);
    }

    /**
     * Scope pour les chambres suspendues
     */
    public function scopeSuspended($query)
    {
        return $query->where('is_suspended', true);
    }

    /**
     * Vérifier si la chambre est active
     */
    public function isActive(): bool
    {
        return !$this->is_suspended;
    }

    /**
     * Vérifier si la chambre est suspendue
     */
    public function isSuspended(): bool
    {
        return $this->is_suspended;
    }

    /**
     * Suspendre la chambre
     */
    public function suspend(string $reason = null): void
    {
        $this->update([
            'is_suspended' => true,
            'suspended_at' => now(),
            'suspension_reason' => $reason,
        ]);
    }

    /**
     * Réactiver la chambre
     */
    public function reactivate(): void
    {
        $this->update([
            'is_suspended' => false,
            'suspended_at' => null,
            'suspension_reason' => null,
        ]);
    }
}
