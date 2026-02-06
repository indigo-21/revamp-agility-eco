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
        Schema::create('navigation_audit_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('account_level_id')->nullable()->constrained('account_levels');
            $table->foreignId('navigation_id')->nullable()->constrained('navigations');

            $table->string('navigation_link')->nullable();
            $table->string('route_name')->nullable();

            $table->string('uri');
            $table->string('method', 10);

            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('referer')->nullable();

            $table->unsignedSmallInteger('status_code')->nullable();
            $table->boolean('allowed')->default(false);
            $table->unsignedTinyInteger('required_permission')->default(1);
            $table->unsignedTinyInteger('granted_permission')->default(0);

            $table->timestamps();

            $table->index(['created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['navigation_link', 'created_at']);
            $table->index(['allowed', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigation_audit_logs');
    }
};
