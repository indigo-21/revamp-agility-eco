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
        Schema::create('property_inspector_measures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_inspector_id')->constrained();
            $table->foreignId('measure_id')->constrained();
            $table->decimal('fee_value', 10, 2);
            $table->string('fee_currency');
            $table->date('expiry');
            $table->string('cert');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_inspector_measures');
    }
};
