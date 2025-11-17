<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chamber_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chamber_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('role', ['manager', 'member'])->default('member');
            $table->timestamps();
            $table->unique(['chamber_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chamber_user');
    }
};





