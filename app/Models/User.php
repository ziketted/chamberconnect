<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'facebook_id',
        'avatar',
        'phone',
        'company',
        'nationality',
        'professional_email',
        'is_admin',
        'theme_preference',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'integer',
        ];
    }

    /**
     * Relation avec les chambres dont l'utilisateur est membre
     * Inclut tous les champs pivot: role, status, position
     */
    public function chambers()
    {
        return $this->belongsToMany(Chamber::class)
            ->withPivot(['role', 'status', 'position'])
            ->withTimestamps();
    }

    /**
     * Chambres où l'utilisateur est membre approuvé (pas applicant)
     */
    public function approvedChambers()
    {
        return $this->chambers()
            ->wherePivot('status', 'approved')
            ->whereIn('chamber_user.role', ['member', 'manager']);
    }

    /**
     * Chambres où l'utilisateur a fait une demande en attente
     */
    public function pendingChamberRequests()
    {
        return $this->chambers()
            ->wherePivot('role', 'applicant')
            ->wherePivot('status', 'pending');
    }

    public function managesChamber(Chamber $chamber): bool
    {
        return $this->chambers()->where('chamber_id', $chamber->id)->wherePivot('role', 'manager')->exists();
    }

    // Constantes pour les rôles
    const ROLE_USER = 0;           // Utilisateur normal
    const ROLE_SUPER_ADMIN = 1;    // Super administrateur
    const ROLE_CHAMBER_MANAGER = 2; // Gestionnaire de chambre

    /**
     * Vérifie si l'utilisateur est un super administrateur
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_admin === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Vérifie si l'utilisateur est un gestionnaire de chambre
     */
    public function isChamberManager(): bool
    {
        return $this->is_admin === self::ROLE_CHAMBER_MANAGER;
    }

    /**
     * Vérifie si l'utilisateur est un utilisateur normal
     */
    public function isRegularUser(): bool
    {
        return $this->is_admin === self::ROLE_USER;
    }

    /**
     * Vérifie si l'utilisateur a des privilèges administratifs (super admin ou gestionnaire)
     */
    public function hasAdminPrivileges(): bool
    {
        return $this->isSuperAdmin() || $this->isChamberManager();
    }

    /**
     * Obtient le texte du rôle de l'utilisateur
     */
    public function getRoleText(): string
    {
        switch ($this->is_admin) {
            case self::ROLE_SUPER_ADMIN:
                return 'Super Administrateur';
            case self::ROLE_CHAMBER_MANAGER:
                return 'Gestionnaire de Chambre';
            case self::ROLE_USER:
            default:
                return 'Utilisateur';
        }
    }

    /**
     * Obtient les chambres que l'utilisateur peut gérer
     */
    public function managedChambers()
    {
        if ($this->isSuperAdmin()) {
            // Super admin peut gérer toutes les chambres
            return Chamber::query();
        }
        
        if ($this->isChamberManager()) {
            // Gestionnaire peut gérer ses chambres assignées
            return $this->chambers()->wherePivot('role', 'manager');
        }
        
        return Chamber::whereRaw('1 = 0'); // Aucune chambre pour les utilisateurs normaux
    }

    /**
     * Relation avec les événements auxquels l'utilisateur participe
     */
    public function events()
    {
        return $this->belongsToMany(Event::class)
            ->withPivot(['status', 'reserved_at', 'confirmed_at', 'notes'])
            ->withTimestamps();
    }

    /**
     * Événements réservés par l'utilisateur
     */
    public function reservedEvents()
    {
        return $this->events()->wherePivot('status', 'reserved');
    }

    /**
     * Événements confirmés par l'utilisateur
     */
    public function confirmedEvents()
    {
        return $this->events()->wherePivot('status', 'confirmed');
    }

    /**
     * Vérifier si l'utilisateur a réservé un événement
     */
    public function hasBookedEvent(Event $event): bool
    {
        return $this->events()->where('event_id', $event->id)->exists();
    }
}
