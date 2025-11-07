<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chamber;

class ChamberSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Créer la chambre d'Abidjan (certifiée)
        Chamber::updateOrCreate(
            ['slug' => 'chambre-commerce-abidjan'],
            [
                'name' => 'Chambre de Commerce d\'Abidjan',
                'slug' => 'chambre-commerce-abidjan',
                'description' => 'Chambre de Commerce et d\'Industrie d\'Abidjan',
                'location' => 'Abidjan, Côte d\'Ivoire',
                'verified' => true,
                'state_number' => 'CCI-AB-2024-001',
                'certification_date' => '2024-01-15',
                'certification_notes' => 'Certification initiale - Conforme aux standards nationaux'
            ]
        );

        // Créer la chambre de Dakar (non certifiée)
        Chamber::updateOrCreate(
            ['slug' => 'chambre-commerce-dakar'],
            [
                'name' => 'Chambre de Commerce de Dakar',
                'slug' => 'chambre-commerce-dakar',
                'description' => 'Chambre de Commerce et d\'Industrie de Dakar',
                'location' => 'Dakar, Sénégal',
                'verified' => false,
                'state_number' => null,
                'certification_date' => null,
                'certification_notes' => null
            ]
        );

        // Créer la chambre de Paris (certifiée)
        Chamber::updateOrCreate(
            ['slug' => 'cci-paris'],
            [
                'name' => 'CCI Paris',
                'slug' => 'cci-paris',
                'description' => 'Chambre de Commerce et d\'Industrie de Paris',
                'location' => 'Paris, France',
                'verified' => true,
                'state_number' => 'CCI-PA-2024-003',
                'certification_date' => '2024-02-20',
                'certification_notes' => 'Certification européenne validée'
            ]
        );
    }
}