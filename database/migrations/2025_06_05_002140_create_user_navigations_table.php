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
        Schema::create('user_navigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_level_id')->constrained();
            $table->foreignId('navigation_id')->constrained('navigations');
            // $table->boolean('accessed');
            $table->integer('permission')->default(0); // 0: no access, 1: read, 2: write, 3: full access
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_navigations');
    }
};
