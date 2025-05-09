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
        Schema::create('page_become_instructors', function (Blueprint $table) {
            $table->id();
            $table->longText('title1')->nullable();
            $table->longText('small_desc')->nullable();
            $table->longText('iamge')->nullable();
            $table->longText('form_title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_become_instructors');
    }
};
