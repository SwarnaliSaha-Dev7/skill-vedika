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
        Schema::create('section_live_free_demo', function (Blueprint $table) {
            $table->id();
            $table->longText('title')->nullable();
            $table->longText('image')->nullable();
            $table->longText('point1')->nullable();
            $table->longText('point2')->nullable();
            $table->longText('point3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_live_free_demo');
    }
};
