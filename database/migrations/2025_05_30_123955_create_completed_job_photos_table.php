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
        Schema::create('completed_job_photos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('completed_job_id');
            $table->foreign('completed_job_id')->references('id')->on('completed_jobs')->onDelete('cascade');
            $table->string('filename');
            $table->string('file_path');
            $table->boolean('status')->default(0); // 0 for pending, 1 for stored
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_job_photos');
    }
};
