<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChamberListController extends Controller
{
    public function index()
    {
        // Données factices d'illustration (design)
        $data = [
            'userRole' => [
                'role' => 'Super admin',
                'has_global_access' => true,
            ],
            'chambers' => [
                [
                    'id' => 1,
                    'code' => 'CH CD',
                    'name' => 'Chambre Suisse — RDC',
                    'description' => 'Plateforme de coopération économique entre la Suisse et la République',
                    'members_count' => 1842,
                    'is_subscribed' => false,
                    'is_certified' => true,
                    'upcoming_events' => 5,
                    'activity_level' => 'Très active',
                    'slug' => 'chambre-suisse-rdc'
                ],
                [
                    'id' => 2,
                    'code' => 'FR MA',
                    'name' => 'Chambre France — Maroc',
                    'description' => 'Réseau d\'affaires franco-marocain, promotion des échanges et partenariats',
                    'members_count' => 2310,
                    'is_subscribed' => true,
                    'is_certified' => true,
                    'upcoming_events' => 3,
                    'activity_level' => 'Très active',
                    'slug' => 'chambre-france-maroc'
                ],
                [
                    'id' => 3,
                    'code' => 'CA CI',
                    'name' => 'Chambre Canada — Côte d\'Ivoire',
                    'description' => 'Connecter les entreprises canadiennes et ivoiriennes autour d\'opportunités',
                    'members_count' => 1154,
                    'is_subscribed' => false,
                    'is_certified' => false,
                    'upcoming_events' => 2,
                    'activity_level' => 'Active',
                    'slug' => 'chambre-canada-cote-ivoire'
                ],
                [
                    'id' => 4,
                    'code' => 'BE CM',
                    'name' => 'Chambre Belgique — Cameroun',
                    'description' => 'Faciliter les échanges belgo-camerounais et l\'accès aux marchés.',
                    'members_count' => 987,
                    'is_subscribed' => true,
                    'is_certified' => true,
                    'upcoming_events' => 4,
                    'activity_level' => 'Très active',
                    'slug' => 'chambre-belgique-cameroun'
                ],
            ],
            'filters' => [
                'types' => ['Forum', 'Atelier', 'Participation'],
                'periods' => ['Cette semaine', 'Ce mois', 'Trimestre'],
            ],
        ];

        return view('chambers.index', $data);
    }
}
