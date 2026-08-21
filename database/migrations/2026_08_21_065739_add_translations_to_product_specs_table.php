<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_specs', function (Blueprint $table) {
            // spec_key (label) is translated; spec_value normally isn't
            // (numbers/units/model codes stay identical) but the column is
            // provided for the rare spec whose *value* is itself descriptive
            // text rather than a number/unit.
            $table->string('spec_group_en')->nullable()->after('spec_group');
            $table->string('spec_key_en')->nullable()->after('spec_key');
            $table->string('spec_value_en')->nullable()->after('spec_value');
        });
    }

    public function down(): void
    {
        Schema::table('product_specs', function (Blueprint $table) {
            $table->dropColumn(['spec_group_en', 'spec_key_en', 'spec_value_en']);
        });
    }
};
