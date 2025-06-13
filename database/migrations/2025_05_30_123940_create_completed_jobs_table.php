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
        Schema::create('completed_jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('job_id')->constrained();
            $table->time('time');
            $table->string('geostamp');
            $table->string('pass_fail');
            $table->longText('comments');
            $table->integer('remediation')->default(0);
            $table->integer('appeal')->default(0);
            $table->foreignId('survey_question_set_id')->constrained();
            $table->foreignId('survey_question_id')->constrained();
            $table->dateTime('installer_first_access')->nullable();
            $table->dateTime('installer_first_access_completed_job')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_jobs');
    }
};
