<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'chamber_id',
        'created_by',
        'title',
        'type',
        'description',
        'date',
        'time',
        'location',
        'lien_live',
        'max_participants',
        'mode',
        'country',
        'city',
        'address',
        'cover_image_path',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function chamber(): BelongsTo
    {
        return $this->belongsTo(Chamber::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['status', 'reserved_at', 'confirmed_at', 'notes'])
            ->withTimestamps();
    }

    public function reservedParticipants(): BelongsToMany
    {
        return $this->participants()->wherePivot('status', 'reserved');
    }

    public function confirmedParticipants(): BelongsToMany
    {
        return $this->participants()->wherePivot('status', 'confirmed');
    }

    // Vérifier si l'événement est complet
    public function isFull(): bool
    {
        if (!$this->max_participants) {
            return false;
        }
        
        return $this->participants()->count() >= $this->max_participants;
    }

    // Obtenir le nombre de places restantes
    public function availableSpots(): int
    {
        if (!$this->max_participants) {
            return PHP_INT_MAX;
        }
        
        return max(0, $this->max_participants - $this->participants()->count());
    }

    // Vérifier si un utilisateur a réservé
    public function isBookedBy(User $user): bool
    {
        return $this->participants()->where('user_id', $user->id)->exists();
    }

    // Obtenir le statut de réservation d'un utilisateur
    public function getBookingStatus(User $user): ?string
    {
        $pivot = $this->participants()->where('user_id', $user->id)->first()?->pivot;
        return $pivot?->status;
    }

    // Mettre à jour le statut de l'événement si complet
    public function updateStatusIfFull(): void
    {
        if ($this->isFull() && $this->status === 'upcoming') {
            $this->update(['status' => 'full']);
        } elseif (!$this->isFull() && $this->status === 'full') {
            $this->update(['status' => 'upcoming']);
        }
    }

    // Relation avec les likes
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_likes')
            ->withTimestamps();
    }

    // Vérifier si un utilisateur a liké l'événement
    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    // Obtenir le nombre total de likes
    public function getLikesCountAttribute(): int
    {
        return $this->likes()->count();
    }
}







