<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('slug_en')->nullable()->unique()->after('slug');
            $table->text('summary_en')->nullable()->after('summary');
            $table->longText('body_en')->nullable()->after('body');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'slug_en', 'summary_en', 'body_en']);
        });
    }
};
