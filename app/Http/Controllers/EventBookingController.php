<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventBookingController extends Controller
{
    /**
     * Réserver une place pour un événement
     */
    public function book(Request $request, Event $event)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur a déjà réservé
        if ($user->hasBookedEvent($event)) {
            return back()->with('error', 'Vous avez déjà réservé une place pour cet événement.');
        }

        // Vérifier si l'événement est complet
        if ($event->isFull()) {
            return back()->with('error', 'Désolé, cet événement est complet. Fin des réservations.');
        }

        // Vérifier si l'événement est encore à venir
        if ($event->status !== 'upcoming') {
            return back()->with('error', 'Les réservations ne sont plus possibles pour cet événement.');
        }

        // Créer la réservation
        $user->events()->attach($event->id, [
            'status' => 'reserved',
            'reserved_at' => now(),
            'notes' => $request->input('notes')
        ]);

        // Mettre à jour le statut de l'événement si nécessaire
        $event->updateStatusIfFull();

        return back()->with('success', 'Votre place a été réservée avec succès !');
    }

    /**
     * Annuler une réservation
     */
    public function cancel(Request $request, Event $event)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur a réservé
        if (!$user->hasBookedEvent($event)) {
            return back()->with('error', 'Vous n\'avez pas de réservation pour cet événement.');
        }

        // Récupérer le statut de la réservation
        $bookingStatus = $event->getBookingStatus($user);

        // Empêcher l'annulation si l'événement a été confirmé
        if ($bookingStatus === 'confirmed') {
            return back()->with('error', 'Vous ne pouvez pas annuler un événement confirmé. Veuillez contacter l\'organisateur si vous ne pouvez plus y participer.');
        }

        // Supprimer la réservation
        $user->events()->detach($event->id);

        // Mettre à jour le statut de l'événement si nécessaire
        $event->updateStatusIfFull();

        return back()->with('success', 'Votre réservation a été annulée.');
    }

    /**
     * Confirmer une réservation
     */
    public function confirm(Request $request, Event $event)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur a réservé
        if (!$user->hasBookedEvent($event)) {
            return back()->with('error', 'Vous n\'avez pas de réservation pour cet événement.');
        }

        // Mettre à jour le statut à confirmé
        $user->events()->updateExistingPivot($event->id, [
            'status' => 'confirmed',
            'confirmed_at' => now()
        ]);

        return back()->with('success', 'Votre participation a été confirmée !');
    }

    /**
     * Afficher les événements réservés par l'utilisateur
     */
    public function myBookings()
    {
        $user = Auth::user();
        
        // Événements à venir - Sans pagination (généralement peu nombreux)
        $upcomingEvents = $user->events()
            ->where('date', '>=', now())
            ->with('chamber')
            ->orderBy('date', 'asc')
            ->get();

        // Événements passés - Avec pagination (peuvent être nombreux)
        $pastEvents = $user->events()
            ->where('date', '<', now())
            ->with('chamber')
            ->orderBy('date', 'desc')
            ->paginate(10); // 10 événements passés par page
         

        return view('events.my-bookings', compact('upcomingEvents', 'pastEvents'));
    }
}