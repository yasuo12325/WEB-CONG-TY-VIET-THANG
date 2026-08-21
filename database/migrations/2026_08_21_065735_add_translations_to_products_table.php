<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->string('slug_en')->nullable()->unique()->after('slug');
            $table->string('short_description_en')->nullable()->after('short_description');
            $table->longText('description_en')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name_en', 'slug_en', 'short_description_en', 'description_en']);
        });
    }
};
