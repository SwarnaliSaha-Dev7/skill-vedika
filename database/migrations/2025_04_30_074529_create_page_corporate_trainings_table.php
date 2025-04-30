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
        Schema::create('page_corporate_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('sec1_title')->nullable();
            $table->longText('sec1_desc')->nullable();
            $table->string('sec1_img')->nullable();

            $table->string('sec2_title1')->nullable();
            $table->string('sec2_title2')->nullable();
            $table->longText('sec2_desc')->nullable();
            $table->string('sec2_img')->nullable();

            $table->string('sec_portfolio_title')->nullable();
            $table->longText('sec_portfolio_small_desc')->nullable();
            $table->string('sec_portfolio_option1_lebel')->nullable();
            $table->longText('sec_portfolio_option1_desc')->nullable();
            $table->string('sec_portfolio_option1_img')->nullable();
            $table->string('sec_portfolio_option2_lebel')->nullable();
            $table->longText('sec_portfolio_option2_desc')->nullable();
            $table->string('sec_portfolio_option2_img')->nullable();
            $table->string('sec_portfolio_option3_lebel')->nullable();
            $table->longText('sec_portfolio_option3_desc')->nullable();
            $table->string('sec_portfolio_option3_img')->nullable();
            $table->string('sec_portfolio_option4_lebel')->nullable();
            $table->longText('sec_portfolio_option4_desc')->nullable();
            $table->string('sec_portfolio_option4_img')->nullable();
            $table->string('sec_portfolio_option5_lebel')->nullable();
            $table->longText('sec_portfolio_option5_desc')->nullable();
            $table->string('sec_portfolio_option5_img')->nullable();
            $table->string('sec_portfolio_option6_lebel')->nullable();
            $table->longText('sec_portfolio_option6_desc')->nullable();
            $table->string('sec_portfolio_option6_img')->nullable();

            $table->string('sec_corporate_training_title')->nullable();
            $table->longText('sec_corporate_training_small_desc')->nullable();
            $table->string('sec_corporate_training_sec1_img')->nullable();
            $table->longText('sec_corporate_training_sec1_content')->nullable();
            $table->string('sec_corporate_training_sec2_img')->nullable();
            $table->longText('sec_corporate_training_sec2_content')->nullable();

            $table->string('sec_talent_development_title')->nullable();
            $table->longText('sec_talent_development_small_desc')->nullable();

            $table->string('sec_talent_development_div1_lebel')->nullable();
            $table->longText('sec_talent_development_div1_desc')->nullable();
            $table->string('sec_talent_development_div2_lebel')->nullable();
            $table->longText('sec_talent_development_div2_desc')->nullable();
            $table->string('sec_talent_development_div3_lebel')->nullable();
            $table->longText('sec_talent_development_div3_desc')->nullable();
            $table->string('sec_talent_development_div4_lebel')->nullable();
            $table->longText('sec_talent_development_div4_desc')->nullable();
            $table->string('sec_talent_development_div5_lebel')->nullable();
            $table->longText('sec_talent_development_div5_desc')->nullable();
            $table->string('sec_talent_development_div6_lebel')->nullable();
            $table->longText('sec_talent_development_div6_desc')->nullable();

            $table->string('sec_ready_to_empower_workforce_title')->nullable();
            $table->longText('sec_ready_to_empower_workforce_desc')->nullable();
            $table->string('sec_ready_to_empower_workforce_img')->nullable();
            $table->string('sec_ready_to_empower_workforce_button_text')->nullable();

            $table->string('hr_professional_faqs_heading')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_corporate_trainings');
    }
};
