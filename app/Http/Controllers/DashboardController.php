<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userRole = [
            'role' => 'Super admin',
            'has_global_access' => true,
        ];

        $my_chambers = [
            [
                'id' => 1,
                'name' => 'CCI Abidjan',
                'avatar' => 'https://images.unsplash.com/photo-1550948390-6eb7fa773072?q=80&w=1600&auto=format&fit=crop',
                'upcoming_forums' => 12,
            ],
            [
                'id' => 2,
                'name' => 'Chambre de Dakar',
                'avatar' => 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?q=80&w=1600&auto=format&fit=crop',
                'upcoming_forums' => 8,
            ],
            [
                'id' => 3,
                'name' => 'CCI Paris',
                'avatar' => 'https://images.unsplash.com/photo-1499856871958-5b9627545d1a?q=80&w=1600&auto=format&fit=crop',
                'upcoming_forums' => 5,
            ],
        ];

        $upcoming_events = [
            [
                'chamber' => [
                    'name' => 'Chambre de Commerce d\'Abidjan',
                    'avatar' => 'https://images.unsplash.com/photo-1550948390-6eb7fa773072?q=80&w=1600&auto=format&fit=crop',
                ],
                'title' => 'Forum régional sur les opportunités d\'exportation et les partenariats public-privé',
                'description' => 'Interventions des ministères, incubateurs et entreprises.',
                'date' => '16 octobre',
                'time' => '10:00 GMT',
                'type' => 'Forum',
                'tags' => ['Export', 'PPP', 'Régional'],
                'is_open_to_all' => true,
            ],
            [
                'chamber' => [
                    'name' => 'Chambre de Commerce de Dakar',
                    'avatar' => 'https://images.unsplash.com/photo-1506784983877-45594efa4cbe?q=80&w=1600&auto=format&fit=crop',
                ],
                'title' => 'Forum sur l\'industrialisation, la logistique portuaire et les zones économiques spéciales',
                'description' => 'Networking B2B & B2G.',
                'date' => '20 octobre',
                'time' => '14:00 GMT',
                'type' => 'Forum',
                'tags' => ['Industrie', 'Logistique'],
                'is_open_to_all' => true,
            ],
            [
                'chamber' => [
                    'name' => 'CCI Paris Île-de-France',
                    'avatar' => 'https://images.unsplash.com/photo-1499856871958-5b9627545d1a?q=80&w=1600&auto=format&fit=crop',
                ],
                'title' => 'Forum Tech & Financement: startups, fonds d\'investissement, dispositifs publics',
                'description' => 'Sessions pitch et RDV investisseurs.',
                'date' => '02 novembre',
                'time' => '09:00 GMT',
                'type' => 'Forum',
                'tags' => ['Tech', 'Financement'],
                'is_open_to_all' => true,
            ],
        ];

        return view('dashboard', compact('userRole', 'my_chambers', 'upcoming_events'));
    }
}
