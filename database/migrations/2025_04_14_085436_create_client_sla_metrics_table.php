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
        Schema::create('client_sla_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->integer('client_maximum_retries')->unsigned()->nullable()->default(12);
            $table->string('maximum_booking_attemps')->nullable();
            $table->string('maximum_remediation_attemps')->nullable();
            $table->string('maximum_no_show')->nullable();
            $table->string('maximum_number_appeals')->nullable();
            $table->string('job_deadline')->nullable();
            $table->string('cat1_remediate_notify')->nullable();
            $table->boolean('cat1_remediate_notify_duration_unit')->nullable()->default(1)->comment('1 = Hours, 2 = Days');
            $table->string('cat1_remediate_complete')->nullable();
            $table->boolean('cat1_remediate_complete_duration_unit')->nullable()->default(1)->comment('1 = Hours, 2 = Days');
            $table->string('cat1_reinspect_remediation')->nullable();
            $table->boolean('cat1_reinspect_remediation_duration_unit')->nullable()->default(1)->comment('1 = Hours, 2 = Days');
            $table->string('cat1_challenge')->nullable();
            $table->boolean('cat1_challenge_duration_unit')->nullable()->default(1)->comment('1 = Hours, 2 = Days');
            $table->string('cat1_remediate_no_access')->nullable();
            $table->boolean('cat1_remediate_no_access_duration_unit')->nullable()->default(1)->comment('1 = Hours, 2 = Days');
            $table->string('cat1_unremediated')->nullable();
            $table->boolean('cat1_unremediated_duration_unit')->nullable()->default(1)->comment('1 = Hours, 2 = Days');
            $table->string('nc_remediate_notify')->nullable();
            $table->boolean('nc_remediate_notify_duration_unit')->nullable()->default(1)->comment('1 = Hours, 2 = Days');
            $table->string('nc_remediate_complete')->nullable();
            $table->boolean('nc_remediate_complete_duration_unit')->nullable()->default(1)->comment('1 = Hours, 2 = Days');
            $table->string('nc_reinspect_remediation')->nullable();
            $table->boolean('nc_reinspect_remediation_duration_unit')->nullable()->default(1)->comment('1 = Hours, 2 = Days');
            $table->string('nc_challenge')->nullable();
            $table->boolean('nc_challenge_duration_unit')->nullable()->default(1)->comment('1 = Hours, 2 = Days');
            $table->string('nc_remediate_no_access')->nullable();
            $table->boolean('nc_remediate_no_access_duration_unit')->nullable()->default(1)->comment('1 = Hours, 2 = Days');
            $table->string('nc_unremediated')->nullable();
            $table->boolean('nc_unremediated_duration_unit')->nullable()->default(1)->comment('1 = Hours, 2 = Days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_sla_metrics');
    }
};
