<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChamberListController extends Controller
{
    public function index()
    {
        // Récupérer les 5 événements du mois en cours
        $monthlyEvents = \App\Models\Event::with('chamber')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->take(5)
            ->get()
            ->map(function($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'chamber' => $event->chamber->name ?? 'Chambre inconnue',
                    'date' => $event->date->format('d M'),
                    'participants' => $event->max_participants ?? rand(50, 300),
                    'type' => strtolower($event->type ?? 'event'),
                    'slug' => $event->slug ?? $event->id
                ];
            });

        // Récupérer les chambres réelles de la base de données
        $chambers = \App\Models\Chamber::withCount('members')
            ->with(['events' => function($query) {
                $query->where('date', '>=', now())->take(5);
            }])
            ->get()
            ->map(function($chamber) {
                // Générer un code basé sur le nom de la chambre
                $words = explode(' ', $chamber->name);
                $code = '';
                foreach($words as $word) {
                    if(strlen($code) < 4 && strlen($word) > 2) {
                        $code .= strtoupper(substr($word, 0, 2));
                    }
                }
                if(strlen($code) < 4) {
                    $code = strtoupper(substr($chamber->name, 0, 4));
                }
                
                $isSubscribed = auth()->check() ? $chamber->members->contains(auth()->id()) : false;
                
                return [
                    'id' => $chamber->id,
                    'code' => $code,
                    'name' => $chamber->name,
                    'description' => $chamber->description ?? 'Description de la chambre de commerce',
                    'members_count' => $chamber->members_count,
                    'is_subscribed' => $isSubscribed,
                    'is_certified' => $chamber->verified,
                    'upcoming_events' => $chamber->events->count(),
                    'activity_level' => $chamber->events->count() > 3 ? 'Très active' : ($chamber->events->count() > 1 ? 'Active' : 'Modérée'),
                    'slug' => $chamber->slug,
                    'logo_path' => $chamber->logo_path,
                    'location' => $chamber->location,
                    'certification_date' => $chamber->certification_date,
                    'created_at' => $chamber->created_at
                ];
            })
            ->sortBy(function($chamber) {
                // Trier pour afficher d'abord les chambres dont l'utilisateur n'est pas membre
                // Les chambres non-souscrites auront une priorité de 0, les souscrites auront 1
                return $chamber['is_subscribed'] ? 1 : 0;
            })
            ->values(); // Réindexer la collection

        $data = [
            'userRole' => [
                'role' => auth()->check() && auth()->user()->isSuperAdmin() ? 'Super admin' : 'Utilisateur',
                'has_global_access' => auth()->check() && auth()->user()->isSuperAdmin(),
            ],
            'chambers' => $chambers,
            'monthlyEvents' => $monthlyEvents,
            'filters' => [
                'types' => ['Forum', 'Atelier', 'Participation'],
                'periods' => ['Cette semaine', 'Ce mois', 'Trimestre'],
            ],
        ];

        return view('chambers.index', $data);
    }
}
