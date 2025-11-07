<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chambers', function (Blueprint $table) {
            $table->string('state_number')->nullable()->unique()->after('verified');
            $table->date('certification_date')->nullable()->after('state_number');
            $table->text('certification_notes')->nullable()->after('certification_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chambers', function (Blueprint $table) {
            $table->dropColumn(['state_number', 'certification_date', 'certification_notes']);
        });
    }
};