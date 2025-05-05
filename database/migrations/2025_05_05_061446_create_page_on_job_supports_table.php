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
        Schema::create('page_on_job_supports', function (Blueprint $table) {
            $table->id();
            $table->string('sec1_title')->nullable();
            $table->longText('sec1_desc')->nullable();
            $table->string('sec1_img')->nullable();
            $table->longText('sec2_content')->nullable();
            $table->string('sec2_img')->nullable();
            $table->longText('sec3_content')->nullable();
            $table->string('sec3_img')->nullable();

            $table->string('sec4_heading')->nullable();
            $table->string('sec4_point1_lebel')->nullable();
            $table->longText('sec4_point1_desc')->nullable();
            $table->string('sec4_point1_img')->nullable();
            $table->string('sec4_point2_lebel')->nullable();
            $table->longText('sec4_point2_desc')->nullable();
            $table->string('sec4_point2_img')->nullable();
            $table->string('sec4_point3_lebel')->nullable();
            $table->longText('sec4_point3_desc')->nullable();
            $table->string('sec4_point3_img')->nullable();
            $table->string('sec4_point4_lebel')->nullable();
            $table->longText('sec4_point4_desc')->nullable();
            $table->string('sec4_point4_img')->nullable();
            $table->string('sec4_point5_lebel')->nullable();
            $table->longText('sec4_point5_desc')->nullable();
            $table->string('sec4_point5_img')->nullable();

            $table->string('sec5_heading')->nullable();
            $table->string('sec5_point1_lebel')->nullable();
            $table->longText('sec5_point1_desc')->nullable();
            $table->string('sec5_point2_lebel')->nullable();
            $table->longText('sec5_point2_desc')->nullable();
            $table->string('sec5_point3_lebel')->nullable();
            $table->longText('sec5_point3_desc')->nullable();
            $table->string('sec5_point4_lebel')->nullable();
            $table->longText('sec5_point4_desc')->nullable();

            $table->longText('sec6_content')->nullable();
            $table->string('sec6_img')->nullable();

            $table->string('sec_ready_to_empower_workforce_title')->nullable();
            $table->longText('sec_ready_to_empower_workforce_desc')->nullable();
            $table->string('sec_ready_to_empower_workforce_img')->nullable();
            $table->string('sec_ready_to_empower_workforce_button_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_on_job_supports');
    }
};
