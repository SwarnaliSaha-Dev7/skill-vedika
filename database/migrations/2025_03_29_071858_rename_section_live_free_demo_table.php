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
        Schema::rename('section_live_free_demo', 'section_live_free_demos');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('section_live_free_demos', 'section_live_free_demo');
    }
};
