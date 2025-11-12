<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mettre à jour tous les utilisateurs avec is_admin NULL vers 0 (utilisateur normal)
        // Cela garantit que tous les utilisateurs ont un rôle défini
        DB::table('users')
            ->whereNull('is_admin')
            ->update(['is_admin' => 0]); // 0 = Utilisateur normal
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionnel : remettre les valeurs NULL si nécessaire
        // DB::table('users')->where('is_admin', 0)->update(['is_admin' => null]);
    }
};