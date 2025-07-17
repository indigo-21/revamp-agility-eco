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
        Schema::table('jobs', function (Blueprint $table) {
            // Add composite indexes for common filter combinations
            $table->index(['job_status_id', 'close_date'], 'jobs_status_close_date_idx');
            $table->index(['client_id', 'job_status_id'], 'jobs_client_status_idx');
            $table->index(['created_at', 'job_status_id'], 'jobs_created_status_idx');
            $table->index(['completed_survey_date'], 'jobs_completed_survey_date_idx');
            $table->index(['installer_id', 'job_status_id'], 'jobs_installer_status_idx');
            $table->index(['property_inspector_id', 'job_status_id'], 'jobs_pi_status_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropIndex('jobs_status_close_date_idx');
            $table->dropIndex('jobs_client_status_idx');
            $table->dropIndex('jobs_created_status_idx');
            $table->dropIndex('jobs_completed_survey_date_idx');
            $table->dropIndex('jobs_installer_status_idx');
            $table->dropIndex('jobs_pi_status_idx');
        });
    }
};
