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
        Schema::create('property_inspectors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->boolean('status')->default(false);
            $table->date('deactivate_date')->nullable();
            $table->boolean('can_book_jobs')->default(false);
            $table->boolean('qai')->default(false);
            $table->integer('qai_rating')->nullable();
            $table->boolean('assessor')->default(false);
            $table->integer('assessor_rating')->nullable();
            $table->boolean('surveyor')->default(false);
            $table->integer('surveyor_rating')->nullable();
            $table->string('pi_employer')->nullable();
            $table->date('photo_expiry')->nullable();
            $table->string('id_badge')->nullable();
            $table->date('id_issued')->nullable();
            $table->date('id_expiry')->nullable();
            $table->date('id_revision')->nullable();
            $table->string('id_location')->nullable();
            $table->date('id_return')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('postcode')->nullable();
            $table->foreignId('charging_scheme_id')->constrained();
            $table->decimal('property_visit_fee', 10, 2)->nullable();
            $table->string('property_fee_currency')->nullable();
            $table->integer('payment_terms')->nullable();
            $table->boolean('vat')->default(false);
            $table->string('vat_no')->nullable();
            $table->string('registered_id_number')->nullable();
            $table->boolean('audit_jobs')->default(false);
            $table->decimal('hours_spent', 8, 2)->nullable();
            $table->boolean('work_sat')->default(false);
            $table->boolean('work_sun')->default(false);
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_inspectors');
    }
};
