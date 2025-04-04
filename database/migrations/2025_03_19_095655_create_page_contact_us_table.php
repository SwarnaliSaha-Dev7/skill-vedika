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
        Schema::create('page_contact_us', function (Blueprint $table) {
            $table->id();
            $table->longText('title1')->nullable();
            $table->longText('desc')->nullable();
            $table->longText('desc_img')->nullable();
            $table->longText('title2')->nullable();
            $table->string('email_label')->nullable();
            $table->string('email_address')->nullable();
            $table->string('phone_label')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('location1_label')->nullable();
            $table->longText('location1_address')->nullable();
            $table->string('location2_label')->nullable();
            $table->longText('location2_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_contact_us');
    }
};
