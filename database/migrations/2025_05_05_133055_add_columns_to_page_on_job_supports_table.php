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
        Schema::table('page_on_job_supports', function (Blueprint $table) {
            $table->string('sec2_title')->nullable()->after('sec1_img');
            $table->string('sec3_title')->nullable()->after('sec2_img');
            $table->string('sec6_title')->nullable()->after('sec5_point4_desc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_on_job_supports', function (Blueprint $table) {
            //
        });
    }
};
