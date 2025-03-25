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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('tla');
            $table->string('name');
            $table->foreignId('client_type_id')->constrained();
            $table->boolean('active')->default(true);
            $table->boolean('can_appeal')->default(false);
            $table->string('job_duration_qai');
            $table->string('job_duration_assessor');
            $table->string('job_duration_survey');
            $table->dateTime('deactivate_date')->nullable();
            $table->string('address1');
            $table->string('address2');
            $table->string('address3');
            $table->string('city');
            $table->string('county');
            $table->string('postcode');
            $table->integer('payment_terms');
            $table->foreignId('charging_scheme_id')->constrained();
            $table->integer('property_charge_value');
            $table->string('property_charge_currency')->default('GBP');
            $table->boolean('appeal_process');
            $table->integer('max_attempts');
            $table->integer('max_noshow');
            $table->integer('max_remediation');
            $table->integer('max_appeal');
            $table->integer('sla_job_deadline');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
