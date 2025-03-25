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
        Schema::create('measures', function (Blueprint $table) {
            $table->id();
            $table->string('measure_cat');
            $table->boolean('cert_required');
            $table->longText('cert_description');
            $table->longText('cert_remediation_advice');
            $table->string('measure_min_qual');
            $table->integer('measure_duration');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measures');
    }
};
