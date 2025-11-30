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
            $table->string('embassy_phone')->nullable()->after('embassy_address');
            $table->string('embassy_website')->nullable()->after('embassy_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chambers', function (Blueprint $table) {
            $table->dropColumn(['embassy_phone', 'embassy_website']);
        });
    }
};
