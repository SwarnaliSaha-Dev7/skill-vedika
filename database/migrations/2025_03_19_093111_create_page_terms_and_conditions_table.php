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
        Schema::create('page_terms_and_conditions', function (Blueprint $table) {
            $table->id();
            $table->longText('title1')->nullable();
            $table->longText('small_desc')->nullable();
            $table->longText('title2')->nullable();
            $table->longText('image')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_terms_and_conditions');
    }
};
