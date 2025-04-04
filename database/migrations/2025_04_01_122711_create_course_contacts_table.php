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
        Schema::create('course_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->string('student_name')->nullable();
            $table->string('student_email')->nullable();
            $table->string('calling_code', 15)->nullable();
            $table->string('phone', 30)->nullable();
            $table->longText('message')->nullable();
            $table->tinyInteger('is_terms_and_condition_checked_by_student')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_contacts');
    }
};
