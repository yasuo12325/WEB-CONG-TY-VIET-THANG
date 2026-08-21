<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Each document row belongs to one language edition (VI by default for
     * everything already uploaded). A product can have both a 'vi' and an
     * 'en' row for the "same" document (e.g. two datasheet PDFs); the public
     * product page shows the current locale's documents and falls back to
     * the Vietnamese ones when no English edition has been uploaded yet.
     */
    public function up(): void
    {
        Schema::table('product_documents', function (Blueprint $table) {
            $table->string('locale', 5)->default('vi')->after('product_id');
        });
    }

    public function down(): void
    {
        Schema::table('product_documents', function (Blueprint $table) {
            $table->dropColumn('locale');
        });
    }
};
