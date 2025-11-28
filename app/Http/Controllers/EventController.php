<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->get('tab', 'for-you'); // Onglet par défaut
        
        // Base query pour tous les événements à venir
        $baseQuery = Event::with(['chamber', 'creator'])
            ->whereHas('chamber') // Only events with valid chambers
            ->where(function($query) {
                $query->where('status', 'upcoming')
                      ->orWhere('status', 'full');
            })
            ->where('date', '>=', now()->toDateString());

        // Récupérer les IDs des chambres de l'utilisateur
        $userChamberIds = $user ? $user->chambers()->pluck('chambers.id')->toArray() : [];

        // Filtrer selon l'onglet sélectionné
        switch ($tab) {
            case 'for-you':
                // Événements des chambres dont l'utilisateur est membre
                if ($user && !empty($userChamberIds)) {
                    $events = $baseQuery->whereIn('chamber_id', $userChamberIds)->get();
                } else {
                    $events = collect(); // Aucun événement si pas connecté ou pas membre
                }
                break;
                
            case 'following':
                // Événements que l'utilisateur a confirmés
                if ($user) {
                    $confirmedEventIds = $user->events()
                        ->wherePivot('status', 'confirmed')
                        ->pluck('events.id')
                        ->toArray();
                    $events = $baseQuery->whereIn('id', $confirmedEventIds)->get();
                } else {
                    $events = collect();
                }
                break;
                
            case 'events':
                // Tous les événements dont l'utilisateur n'est PAS membre de la chambre
                if ($user && !empty($userChamberIds)) {
                    $events = $baseQuery->whereNotIn('chamber_id', $userChamberIds)->get();
                } else {
                    // Si pas connecté, afficher tous les événements
                    $events = $baseQuery->get();
                }
                break;
                
            default:
                $events = $baseQuery->get();
        }

        // Ajouter les informations de réservation
        $upcoming_events = $events->map(function ($event) use ($user) {
            $event->is_booked = $user ? $event->isBookedBy($user) : false;
            $event->booking_status = $user ? $event->getBookingStatus($user) : null;
            $event->participants_count = $event->participants()->count();
            $event->available_spots = $event->availableSpots();
            $event->is_user_chamber_member = $user ? in_array($event->chamber_id, $user->chambers()->pluck('chambers.id')->toArray()) : false;
            return $event;
        })->sortBy('date');

        // Statistiques pour les onglets
        $stats = [];
        if ($user) {
            $stats['for_you_count'] = Event::whereHas('chamber')
                ->whereIn('chamber_id', $userChamberIds)
                ->where('date', '>=', now()->toDateString())
                ->whereIn('status', ['upcoming', 'full'])
                ->count();
                
            $stats['following_count'] = $user->events()
                ->wherePivot('status', 'confirmed')
                ->where('date', '>=', now()->toDateString())
                ->count();
                
            // Events from chambers the user is NOT a member of
            if (!empty($userChamberIds)) {
                $stats['events_count'] = Event::whereHas('chamber')
                    ->whereNotIn('chamber_id', $userChamberIds)
                    ->where('date', '>=', now()->toDateString())
                    ->whereIn('status', ['upcoming', 'full'])
                    ->count();
            } else {
                // If user is not a member of any chamber, show all events
                $stats['events_count'] = Event::whereHas('chamber')
                    ->where('date', '>=', now()->toDateString())
                    ->whereIn('status', ['upcoming', 'full'])
                    ->count();
            }
        } else {
            $stats['events_count'] = Event::whereHas('chamber')
                ->where('date', '>=', now()->toDateString())
                ->whereIn('status', ['upcoming', 'full'])
                ->count();
        }

        $past_events = collect(); // Collection vide
        $user_chambers = $user ? $user->chambers()->get() : collect();

        return view('events.index', compact('upcoming_events', 'past_events', 'user_chambers', 'tab', 'stats'));
    }

    /**
     * Récupérer les détails d'un événement pour l'API
     */
    public function getEventDetails(Request $request, Event $event)
    {
        try {
            $user = Auth::user();
            
            // Charger les relations nécessaires
            $event->load(['chamber', 'participants']);
            
            // Ajouter les informations de réservation si l'utilisateur est connecté
            if ($user) {
                $event->is_booked = $event->isBookedBy($user);
                $event->booking_status = $event->getBookingStatus($user);
            } else {
                $event->is_booked = false;
                $event->booking_status = null;
            }
            
            // Ajouter les statistiques
            $event->participants_count = $event->participants()->count();
            $event->available_spots = $event->availableSpots();
            $event->is_authenticated = $user !== null;
            
            return response()->json([
                'success' => true,
                'event' => $event
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des détails de l\'événement'
            ], 500);
        }
    }
    /**
     * Afficher les détails d'un événement
     */
    public function show(Event $event)
    {
        $user = Auth::user();
        
        // Charger les relations nécessaires
        $event->load(['chamber', 'participants', 'likes']);
        
        // Ajouter les informations de réservation si l'utilisateur est connecté
        if ($user) {
            $event->is_booked = $event->isBookedBy($user);
            $event->booking_status = $event->getBookingStatus($user);
        }
        
        return view('events.detail', compact('event'));
    }
}
