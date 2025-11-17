<?php

namespace App\Http\Controllers;

use App\Models\Chamber;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Notifications\EventPublished;
use Illuminate\Support\Facades\Notification;

class ChamberEventController extends Controller
{
    public function create(Chamber $chamber)
    {
        return view('chambers.events.create', compact('chamber'));
    }

    public function store(Request $request, Chamber $chamber)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:forum,networking,conference,meeting,autres'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date', 'after:today'],
            'time' => ['required', 'string'],
            'mode' => ['required', 'in:online,presentiel,hybride'],
            'location' => ['nullable', 'string', 'max:255'],
            'lien_live' => ['nullable', 'url'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'max_participants' => ['nullable', 'integer', 'min:1'],
            'cover' => ['nullable', 'image', 'max:2048'],
        ]);

        // Validation conditionnelle selon le mode
        if ($data['mode'] === 'online' && empty($data['lien_live'])) {
            return back()->withErrors(['lien_live' => 'Le lien live est requis pour un événement en ligne.']);
        }

        if (in_array($data['mode'], ['presentiel', 'hybride']) && (empty($data['country']) || empty($data['city']))) {
            return back()->withErrors(['country' => 'Le pays et la ville sont requis pour un événement en présentiel.']);
        }

        $event = new Event($data);
        $event->chamber_id = $chamber->id;
        $event->created_by = \Illuminate\Support\Facades\Auth::id();

        if ($request->hasFile('cover')) {
            $event->cover_image_path = $request->file('cover')->store('events/covers', 'public');
        }

        $event->save();

        // Notifier tous les membres approuvés (envoi synchrone)
        $approvedMembers = $chamber->members()
            ->wherePivot('status', 'approved')
            ->whereNotNull('email')
            ->get();
        if ($approvedMembers->isNotEmpty()) {
            Notification::sendNow($approvedMembers, new EventPublished($event, 'created'));
        }

        return redirect()->route('chamber.show', $chamber)->with('success', 'Événement créé avec succès !');
    }

    /**
     * Afficher les participants d'un événement (pour les gestionnaires)
     */
    public function participants(Chamber $chamber, Event $event)
    {
        // Vérifier que l'événement appartient à cette chambre
        if ($event->chamber_id !== $chamber->id) {
            abort(404);
        }

        $participants = $event->participants()
            ->withPivot(['status', 'reserved_at', 'confirmed_at', 'notes'])
            ->orderBy('pivot_reserved_at', 'desc')
            ->get();

        return view('chambers.events.participants', compact('chamber', 'event', 'participants'));
    }

    /**
     * Mettre à jour le statut d'un participant
     */
    public function updateParticipantStatus(Request $request, Chamber $chamber, Event $event, $userId)
    {
        $request->validate([
            'status' => ['required', 'in:reserved,confirmed,attended,cancelled']
        ]);

        $event->participants()->updateExistingPivot($userId, [
            'status' => $request->status,
            'confirmed_at' => $request->status === 'confirmed' ? now() : null
        ]);

        return back()->with('success', 'Statut du participant mis à jour.');
    }
}
