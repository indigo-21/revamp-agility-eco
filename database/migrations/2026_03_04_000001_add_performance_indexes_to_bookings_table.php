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
        Schema::table('bookings', function (Blueprint $table) {
            $table->index(['job_number', 'created_at'], 'bookings_job_number_created_at_idx');
            $table->index(['job_number', 'booking_outcome', 'created_at'], 'bookings_job_outcome_created_at_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('bookings_job_number_created_at_idx');
            $table->dropIndex('bookings_job_outcome_created_at_idx');
        });
    }
};
