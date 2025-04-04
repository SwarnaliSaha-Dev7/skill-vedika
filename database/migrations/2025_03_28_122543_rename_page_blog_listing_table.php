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
        Schema::rename('page_blog_listing', 'page_blog_listings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('page_blog_listings', 'page_blog_listing');

    }
};
