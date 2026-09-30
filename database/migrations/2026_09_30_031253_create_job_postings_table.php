<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->string('slug_en')->nullable()->unique();
            $table->string('location')->nullable();
            $table->string('location_en')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->longText('body')->nullable();
            $table->longText('body_en')->nullable();
            $table->date('deadline')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->string('status')->default('draft'); // draft | published
            $table->timestamp('published_at')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
