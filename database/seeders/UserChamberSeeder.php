<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Chamber;

class UserChamberSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $chambers = Chamber::take(3)->get();

        if ($user && $chambers->count() > 0) {
            foreach ($chambers as $chamber) {
                if (!$user->chambers()->where('chamber_id', $chamber->id)->exists()) {
                    $user->chambers()->attach($chamber->id, [
                        'role' => 'member',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $this->command->info("Utilisateur {$user->name} ajouté à la chambre {$chamber->name}");
                }
            }
        }
    }
}