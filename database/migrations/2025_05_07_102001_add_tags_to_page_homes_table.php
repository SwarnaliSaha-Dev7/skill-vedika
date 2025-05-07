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
        Schema::table('page_homes', function (Blueprint $table) {
            $table->string('course_type_tag1')->nullable()->after('desc2');
            $table->string('course_type_tag2')->nullable()->after('course_type_tag1');
            $table->string('course_type_tag3')->nullable()->after('course_type_tag2');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_homes', function (Blueprint $table) {
            $table->dropColumn('course_type_tag1');
            $table->dropColumn('course_type_tag2');
            $table->dropColumn('course_type_tag3');
        });
    }
};
