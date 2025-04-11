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
        Schema::table('section_job_assistance_programs', function (Blueprint $table) {
            $table->string('icon1')->nullable()->after('content1');
            $table->string('icon2')->nullable()->after('content2');
            $table->string('icon3')->nullable()->after('content3');
            $table->string('icon4')->nullable()->after('content4');
            $table->string('icon5')->nullable()->after('content5');
            $table->string('icon6')->nullable()->after('content6');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section_job_assistance_programs', function (Blueprint $table) {
            $table->dropColumn('icon1');
            $table->dropColumn('icon2');
            $table->dropColumn('icon3');
            $table->dropColumn('icon4');
            $table->dropColumn('icon5');
            $table->dropColumn('icon6');
        });
    }
};
