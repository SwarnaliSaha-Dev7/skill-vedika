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
        Schema::create('page_home', function (Blueprint $table) {
            $table->id();
            $table->longText('title1')->nullable();
            $table->longText('desc1')->nullable();
            $table->longText('img1')->nullable();
            $table->longText('title2')->nullable();
            $table->longText('desc2')->nullable();
            $table->longText('start_building_your_carrer_title')->nullable();
            $table->longText('start_building_your_carrer_img')->nullable();
            $table->longText('blog_list_title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_home');
    }
};
