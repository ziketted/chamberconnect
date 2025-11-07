<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un super administrateur par défaut
        User::firstOrCreate(
            ['email' => 'admin@chamberconnect.cd'],
            [
                'name' => 'Super Administrateur',
                'email' => 'admin@chamberconnect.cd',
                'password' => Hash::make('admin123'),
                'is_admin' => User::ROLE_SUPER_ADMIN,
                'company' => 'ChamberConnect RDC',
                'email_verified_at' => now(),
            ]
        );

        // Créer un gestionnaire de chambre exemple
        User::firstOrCreate(
            ['email' => 'manager@chamberconnect.cd'],
            [
                'name' => 'Gestionnaire Exemple',
                'email' => 'manager@chamberconnect.cd',
                'password' => Hash::make('manager123'),
                'is_admin' => User::ROLE_CHAMBER_MANAGER,
                'company' => 'Chambre de Commerce de Kinshasa',
                'email_verified_at' => now(),
            ]
        );

        // Créer un utilisateur normal exemple
        User::firstOrCreate(
            ['email' => 'user@chamberconnect.cd'],
            [
                'name' => 'Utilisateur Exemple',
                'email' => 'user@chamberconnect.cd',
                'password' => Hash::make('user123'),
                'is_admin' => User::ROLE_USER,
                'company' => 'Entreprise Exemple SARL',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Utilisateurs de test créés :');
        $this->command->info('Super Admin: admin@chamberconnect.cd / admin123');
        $this->command->info('Gestionnaire: manager@chamberconnect.cd / manager123');
        $this->command->info('Utilisateur: user@chamberconnect.cd / user123');
    }
}