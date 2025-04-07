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
        Schema::table('section_key_features', function (Blueprint $table) {
            $table->string('lebel1_image')->nullable()->after('lebel1');
            $table->string('lebel2_image')->nullable()->after('lebel2');
            $table->string('lebel3_image')->nullable()->after('lebel3');
            $table->string('lebel4_image')->nullable()->after('lebel4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section_key_features', function (Blueprint $table) {
            $table->dropColumn('lebel1_image');
            $table->dropColumn('lebel2_image');
            $table->dropColumn('lebel3_image');
            $table->dropColumn('lebel4_image');
        });
    }
};
