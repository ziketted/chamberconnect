<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer d'abord les chambres
        $this->call([
            ChamberSeeder::class,
            BilateralChambersSeeder::class,
        ]);

        // Créer un utilisateur de test par défaut
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Créer les événements d'exemple
        $this->call([
            EventSeeder::class,
        ]);

        // Créer les utilisateurs de test qui vont interagir avec les événements et chambres
        $this->call([
            TestUsersSeeder::class,
        ]);
    }
}
