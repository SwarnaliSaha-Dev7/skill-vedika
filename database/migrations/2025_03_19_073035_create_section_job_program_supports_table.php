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
        Schema::create('section_job_program_supports', function (Blueprint $table) {
            $table->id();
            $table->longText('title')->nullable();
            $table->longText('desc')->nullable();
            $table->string('lebel1')->nullable();
            $table->string('lebel2')->nullable();
            $table->string('lebel3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_job_program_supports');
    }
};
