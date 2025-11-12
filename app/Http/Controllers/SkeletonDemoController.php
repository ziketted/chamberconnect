<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SkeletonDemoController extends Controller
{
    /**
     * Affiche la page de démonstration des skeletons
     */
    public function index()
    {
        return view('examples.skeleton-demo');
    }

    /**
     * Simule un chargement de données avec délai
     */
    public function loadData(Request $request)
    {
        $type = $request->get('type', 'chambers');
        $delay = $request->get('delay', 2); // Délai en secondes
        
        // Simule un délai de chargement
        sleep($delay);
        
        switch ($type) {
            case 'chambers':
                return $this->loadChambers();
            case 'users':
                return $this->loadUsers();
            case 'events':
                return $this->loadEvents();
            case 'stats':
                return $this->loadStats();
            default:
                return response()->json(['error' => 'Type non supporté'], 400);
        }
    }

    private function loadChambers()
    {
        $chambers = [
            [
                'id' => 1,
                'name' => 'Chambre de Commerce Paris',
                'location' => 'Paris, France',
                'members_count' => 1250,
                'status' => 'active'
            ],
            [
                'id' => 2,
                'name' => 'Chambre de Commerce Lyon',
                'location' => 'Lyon, France',
                'members_count' => 890,
                'status' => 'active'
            ],
            [
                'id' => 3,
                'name' => 'Chambre de Commerce Marseille',
                'location' => 'Marseille, France',
                'members_count' => 675,
                'status' => 'pending'
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $chambers,
            'html' => view('partials.chamber-cards', compact('chambers'))->render()
        ]);
    }

    private function loadUsers()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Jean Dupont',
                'email' => 'jean.dupont@example.com',
                'role' => 'Admin',
                'avatar' => null
            ],
            [
                'id' => 2,
                'name' => 'Marie Martin',
                'email' => 'marie.martin@example.com',
                'role' => 'Manager',
                'avatar' => null
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $users,
            'html' => view('partials.user-cards', compact('users'))->render()
        ]);
    }

    private function loadEvents()
    {
        $events = [
            [
                'id' => 1,
                'title' => 'Conférence Annuelle',
                'description' => 'Notre conférence annuelle sur l\'innovation',
                'date' => '2025-12-15',
                'location' => 'Paris'
            ],
            [
                'id' => 2,
                'title' => 'Networking Event',
                'description' => 'Événement de networking pour les membres',
                'date' => '2025-11-20',
                'location' => 'Lyon'
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $events,
            'html' => view('partials.event-cards', compact('events'))->render()
        ]);
    }

    private function loadStats()
    {
        $stats = [
            [
                'title' => 'Chambres Actives',
                'value' => 45,
                'change' => '+12%',
                'icon' => 'building'
            ],
            [
                'title' => 'Membres Total',
                'value' => 12450,
                'change' => '+8%',
                'icon' => 'users'
            ],
            [
                'title' => 'Événements',
                'value' => 28,
                'change' => '+15%',
                'icon' => 'calendar'
            ],
            [
                'title' => 'Revenus',
                'value' => '€125K',
                'change' => '+22%',
                'icon' => 'chart'
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
            'html' => view('partials.dashboard-stats', compact('stats'))->render()
        ]);
    }
}