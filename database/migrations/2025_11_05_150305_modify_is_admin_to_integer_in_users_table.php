<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Modifier is_admin de boolean à integer
            // 0 = Utilisateur normal
            // 1 = Super administrateur 
            // 2 = Gestionnaire de chambre
           // $table->integer('is_admin')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->change();
        });
    }
};