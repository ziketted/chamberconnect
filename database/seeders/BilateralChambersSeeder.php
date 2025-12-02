<?php

namespace Database\Seeders;

use App\Models\Chamber;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BilateralChambersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bilateralChambers = [
            [
                'name' => 'Chambre de Commerce Bilatérale Congo-Chine',
                'description' => 'Chambre de commerce bilatérale facilitant les échanges commerciaux entre la RDC et la Chine',
                'location' => 'Kinshasa, RDC',
                'type' => 'bilateral',
                'embassy_country' => 'Chine',
                'embassy_address' => 'Avenue de la Justice, Gombe, Kinshasa',
                'embassy_phone' => '+243 81 234 5678',
                'embassy_website' => 'https://www.china-embassy-rdc.org',
                'state_number' => 'CCB-CN-2024-001',
                'verified' => false,
            ],
            [
                'name' => 'Chambre de Commerce Bilatérale Congo-Turquie',
                'description' => 'Chambre de commerce bilatérale renforçant les relations économiques entre la RDC et la Turquie',
                'location' => 'Lubumbashi, RDC',
                'type' => 'bilateral',
                'embassy_country' => 'Turquie',
                'embassy_address' => 'Boulevard du 30 Juin, Gombe, Kinshasa',
                'embassy_phone' => '+243 82 345 6789',
                'embassy_website' => 'https://www.turkey-embassy-rdc.org',
                'state_number' => 'CCB-TR-2024-002',
                'verified' => false,
            ],
            [
                'name' => 'Chambre de Commerce Bilatérale Congo-Inde',
                'description' => 'Chambre de commerce bilatérale promouvant les opportunités d\'affaires entre la RDC et l\'Inde',
                'location' => 'Kinshasa, RDC',
                'type' => 'bilateral',
                'embassy_country' => 'Inde',
                'embassy_address' => 'Avenue Wagenia, Gombe, Kinshasa',
                'embassy_phone' => '+243 81 456 7890',
                'embassy_website' => 'https://www.india-embassy-rdc.org',
                'state_number' => 'CCB-IN-2024-003',
                'verified' => false,
            ],
            [
                'name' => 'Chambre de Commerce Bilatérale Congo-Brésil',
                'description' => 'Chambre de commerce bilatérale développant les partenariats commerciaux entre la RDC et le Brésil',
                'location' => 'Kinshasa, RDC',
                'type' => 'bilateral',
                'embassy_country' => 'Brésil',
                'embassy_address' => 'Avenue Colonel Mondjiba, Gombe, Kinshasa',
                'embassy_phone' => '+243 82 567 8901',
                'embassy_website' => 'https://www.brazil-embassy-rdc.org',
                'state_number' => 'CCB-BR-2024-004',
                'verified' => false,
            ],
            [
                'name' => 'Chambre de Commerce Bilatérale Congo-Afrique du Sud',
                'description' => 'Chambre de commerce bilatérale favorisant les échanges économiques entre la RDC et l\'Afrique du Sud',
                'location' => 'Lubumbashi, RDC',
                'type' => 'bilateral',
                'embassy_country' => 'Afrique du Sud',
                'embassy_address' => 'Avenue de la Libération, Gombe, Kinshasa',
                'embassy_phone' => '+243 81 678 9012',
                'embassy_website' => 'https://www.southafrica-embassy-rdc.org',
                'state_number' => 'CCB-ZA-2024-005',
                'verified' => false,
            ],
        ];

        foreach ($bilateralChambers as $chamberData) {
            $chamber = Chamber::create([
                'name' => $chamberData['name'],
                'slug' => Str::slug($chamberData['name']),
                'description' => $chamberData['description'],
                'location' => $chamberData['location'],
                'type' => $chamberData['type'],
                'embassy_country' => $chamberData['embassy_country'],
                'embassy_address' => $chamberData['embassy_address'],
                'embassy_phone' => $chamberData['embassy_phone'],
                'embassy_website' => $chamberData['embassy_website'],
                'state_number' => $chamberData['state_number'],
                'verified' => $chamberData['verified'],
            ]);

            $this->command->info("Chambre bilatérale créée: {$chamber->name} (Numéro: {$chamber->state_number})");
        }

        $this->command->info('✅ 5 chambres bilatérales créées avec succès!');
    }
}
