<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chamber_user', function (Blueprint $table) {
            // Modifier l'ENUM pour inclure 'applicant'
            $table->enum('role', ['manager', 'member', 'applicant'])->default('member')->change();
        });
    }

    public function down(): void
    {
        Schema::table('chamber_user', function (Blueprint $table) {
            // Revenir à l'ENUM original
            $table->enum('role', ['manager', 'member'])->default('member')->change();
        });
    }
};