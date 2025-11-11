<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Ajouter les nouveaux champs
            $table->enum('type', ['forum', 'networking', 'conference', 'meeting', 'autres'])->default('autres')->after('title');
            $table->string('lien_live')->nullable()->after('location');
            $table->integer('max_participants')->nullable()->after('lien_live');
            $table->enum('mode', ['online', 'presentiel', 'hybride'])->default('presentiel')->after('max_participants');
            $table->string('country')->nullable()->after('mode');
            $table->string('city')->nullable()->after('country');
            $table->text('address')->nullable()->after('city');
            
            // Modifier le champ status pour inclure 'full' (complet)
            $table->dropColumn('status');
        });
        
        Schema::table('events', function (Blueprint $table) {
            $table->enum('status', ['upcoming', 'past', 'cancelled', 'full'])->default('upcoming')->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'lien_live', 
                'max_participants',
                'mode',
                'country',
                'city',
                'address'
            ]);
            
            $table->dropColumn('status');
        });
        
        Schema::table('events', function (Blueprint $table) {
            $table->enum('status', ['upcoming', 'past', 'cancelled'])->default('upcoming');
        });
    }
};