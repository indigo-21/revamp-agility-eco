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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_number')->unique();
            $table->string('cert_no');
            $table->foreignId('job_type_id')->constrained();
            $table->foreignId('job_status_id')->constrained();
            $table->dateTime('last_update');
            $table->foreignId('client_id')->constrained();
            $table->boolean('max_attempts')->default(0);
            $table->boolean('max_noshow')->default(0);
            $table->boolean('max_remediation')->default(0);
            $table->boolean('max_appeal')->default(0);
            $table->string('job_remediation_type')->nullable();
            $table->dateTime('deadline');
            $table->dateTime('first_visit_by');
            $table->dateTime('rework_deadline')->nullable();
            $table->string('invoice_status')->nullable();
            $table->foreignId('property_inspector_id')->nullable()->constrained();
            // $table->integer('property_inspector_id')->nullable();
            $table->dateTime('schedule_date')->nullable();
            $table->dateTime('close_date')->nullable();
            $table->integer('duration')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('lodged_by_tmln')->nullable();
            $table->integer('lodged_by_name')->nullable();
            $table->foreignId('installer_id')->nullable()->constrained();
            $table->string('sub_installer_tmln')->nullable();
            $table->foreignId('scheme_id')->nullable()->constrained();
            $table->string('csv_filename')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
