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
        Schema::create('client_key_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->boolean("is_active")->nullable()->default(true);
            $table->boolean('can_job_outcome_appealed')->nullable()->default(true);
            $table->foreignId('charging_scheme_id')->constrained()->onDelete('cascade');
            $table->bigInteger('payment_terms')->nullable();
            $table->decimal('charge_by_property_rate', 10, 2)->nullable();
            $table->string('currency', 100)->nullable()->default('GBP');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_key_details');
    }
};
