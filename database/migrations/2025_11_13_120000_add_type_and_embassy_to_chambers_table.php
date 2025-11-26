<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chambers', function (Blueprint $table) {
            if (!Schema::hasColumn('chambers', 'type')) {
                $table->string('type')->default('national')->after('description');
            }
            if (!Schema::hasColumn('chambers', 'embassy_country')) {
                $table->string('embassy_country')->nullable()->after('type');
            }
            if (!Schema::hasColumn('chambers', 'embassy_address')) {
                $table->string('embassy_address')->nullable()->after('embassy_country');
            }
        });
    }

    public function down(): void
    {
        Schema::table('chambers', function (Blueprint $table) {
            if (Schema::hasColumn('chambers', 'embassy_address')) {
                $table->dropColumn('embassy_address');
            }
            if (Schema::hasColumn('chambers', 'embassy_country')) {
                $table->dropColumn('embassy_country');
            }
            if (Schema::hasColumn('chambers', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};



