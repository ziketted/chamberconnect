<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Chamber;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer 30 utilisateurs de test
        for ($i = 1; $i <= 30; $i++) {
            $user = User::create([
                'name' => "Test User {$i}",
                'email' => "user{$i}@gmail.com",
                'password' => Hash::make('1234567'),
                'email_verified_at' => now(),
                'is_admin' => User::ROLE_USER,
            ]);

            // Récupérer des événements aléatoires pour les liker
            $events = Event::inRandomOrder()->limit(rand(1, 5))->get();
            foreach ($events as $event) {
                // Liker l'événement
                if (!$event->isLikedBy($user)) {
                    $event->likes()->attach($user->id);
                }
            }

            // S'abonner à des chambres aléatoires
            $chambers = Chamber::inRandomOrder()->limit(rand(1, 3))->get();
            foreach ($chambers as $chamber) {
                // S'abonner à la chambre en tant que membre
                if (!$user->chambers()->where('chamber_id', $chamber->id)->exists()) {
                    $user->chambers()->attach($chamber->id, [
                        'role' => 'member',
                        'status' => 'approved',
                    ]);
                }
            }

            $this->command->info("Utilisateur créé: {$user->email}");
        }

        // Créer 5 utilisateurs qui vont demander la création d'une chambre
        for ($i = 31; $i <= 35; $i++) {
            $user = User::create([
                'name' => "Chamber Applicant {$i}",
                'email' => "user{$i}@gmail.com",
                'password' => Hash::make('1234567'),
                'email_verified_at' => now(),
                'is_admin' => User::ROLE_USER,
            ]);

            // Récupérer une chambre aléatoire pour faire une demande
            $chamber = Chamber::inRandomOrder()->first();
            if ($chamber && !$user->chambers()->where('chamber_id', $chamber->id)->exists()) {
                $user->chambers()->attach($chamber->id, [
                    'role' => 'applicant',
                    'status' => 'pending',
                ]);
                
                $this->command->info("Demande de chambre créée pour: {$user->email} -> {$chamber->name}");
            }

            $this->command->info("Utilisateur demandeur créé: {$user->email}");
        }

        $this->command->info('✅ 35 utilisateurs de test créés avec succès!');
        $this->command->info('📧 Emails: user1@gmail.com à user35@gmail.com');
        $this->command->info('🔑 Mot de passe pour tous: 1234567');
    }
}
