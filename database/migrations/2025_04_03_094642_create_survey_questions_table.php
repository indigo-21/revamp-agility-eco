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
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_question_set_id')->constrained();
            $table->string('measure_cat')->nullable();
            $table->string('inspection_stage')->nullable();
            $table->string('question_number')->nullable();
            $table->longText('question')->nullable();
            $table->integer('can_have_photo')->nullable();
            $table->integer('na_allowed')->nullable();
            $table->integer('unable_to_validate_allowed')->nullable();
            $table->integer('remote_reinspection_allowed')->nullable();
            $table->integer('score_monitoring')->nullable();
            $table->string('nc_severity')->nullable();
            $table->integer('uses_dropdown')->nullable();
            $table->longtext('dropdown_list')->nullable();
            $table->string('innovation_measure')->nullable();
            $table->integer('innovation_question_list')->nullable();
            $table->string('measure_type')->nullable();
            $table->string('innovation_product')->nullable();    
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
