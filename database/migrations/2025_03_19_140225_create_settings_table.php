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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->longText('site_url')->nullable();
            $table->string('title')->nullable();
            $table->longText('default_course_image')->nullable();
            $table->longText('default_blog_image')->nullable();
            $table->longText('default_demo_video_url')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->longText('location_1_address')->nullable();
            $table->longText('location_2_address')->nullable();
            $table->longText('facebook_url')->nullable();
            $table->longText('instagram_url')->nullable();
            $table->longText('linkedIn_url')->nullable();
            $table->longText('youtube_url')->nullable();
            $table->longText('twitter_url')->nullable();
            $table->longText('header_logo')->nullable();
            $table->longText('footer_logo')->nullable();
            $table->longText('footer_short_description')->nullable();
            $table->longText('footer_copy_right')->nullable();
            $table->longText('footer_quick_links')->nullable();
            $table->longText('footer_support')->nullable();
            $table->longText('footer_disclaimer')->nullable();
            $table->longText('footer_category')->nullable();
            $table->longText('google_analytics')->nullable();
            $table->string('default_color_theme')->nullable();
            $table->string('current_color_theme')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
