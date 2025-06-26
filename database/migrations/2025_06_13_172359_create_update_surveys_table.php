<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('update_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained();
            $table->uuid('completed_job_id');
            $table->foreign('completed_job_id')->references('id')->on('completed_jobs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->longText('update_outcome');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('update_surveys');
    }
};
