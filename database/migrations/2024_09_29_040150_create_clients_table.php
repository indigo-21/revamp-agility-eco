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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string("client_abbrevation")->nullable();
            $table->foreignId("client_type_id")->constrained()->onDelete('cascade');
            $table->string("address1")->nullable();
            $table->string("address2")->nullable();
            $table->string("address3")->nullable();
            $table->string("city")->nullable();
            $table->string("country")->nullable();
            $table->string("postcode")->nullable();
            $table->datetime("date_last_activated")->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('date_last_deactivated')->nullable();
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
