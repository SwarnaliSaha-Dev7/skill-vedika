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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('course_name')->nullable();
            $table->string('duration_value', 20)->nullable();
            $table->enum('duration_unit', ['hour', 'day', 'week', 'month', 'year'])->nullable();
            $table->enum('batch_type', ['Weekday', 'Weekend', 'Both'])->nullable();
            $table->enum('teaching_mode', ['Online', 'Offline', 'Both'])->nullable();
            $table->float('fee', 10, 2)->nullable();
            $table->string('fee_unit', 20)->nullable();
            $table->longText('demo_video_url')->nullable();
            $table->longText('course_desc')->nullable();
            $table->longText('course_overview')->nullable();
            $table->longText('course_content')->nullable();
            $table->longText('course_logo')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('top_tranding_course')->nullable()->default(0);
            $table->tinyInteger('is_popular')->nullable()->default(0);
            $table->tinyInteger('is_free')->nullable()->default(0);
            $table->tinyInteger('featured')->nullable()->default(0);
            $table->string('slug')->nullable();
            $table->string('mete_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('search_tag')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('seo1')->nullable();
            $table->string('seo2')->nullable();
            $table->string('seo3')->nullable();
            $table->string('feature_field1')->nullable();
            $table->string('feature_field2')->nullable();
            $table->string('feature_field3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
