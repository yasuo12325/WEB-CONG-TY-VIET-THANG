<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            // 'name' is a brand/trademark — not translated.
            $table->string('country_en')->nullable()->after('country');
            $table->string('specialty_en')->nullable()->after('specialty');
        });
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn(['country_en', 'specialty_en']);
        });
    }
};
