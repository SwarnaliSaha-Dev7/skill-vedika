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
        Schema::create('section_job_assistance_programs', function (Blueprint $table) {
            $table->id();
            $table->longText('title')->nullable();
            $table->longText('short_desc')->nullable();
            $table->string('lebel1')->nullable();
            $table->longText('content1')->nullable();
            $table->string('lebel2')->nullable();
            $table->longText('content2')->nullable();
            $table->string('lebel3')->nullable();
            $table->longText('content3')->nullable();
            $table->string('lebel4')->nullable();
            $table->longText('content4')->nullable();
            $table->string('lebel5')->nullable();
            $table->longText('content5')->nullable();
            $table->string('lebel6')->nullable();
            $table->longText('content6')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_job_assistance_programs');
    }
};
