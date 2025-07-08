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
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing unique constraint on email
            $table->dropUnique(['email']);
            
            // Add a composite unique index that allows duplicate emails if one is soft deleted
            // This allows the same email to exist multiple times, but only one can have deleted_at = NULL
            $table->unique(['email', 'deleted_at'], 'users_email_deleted_at_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the composite unique constraint
            $table->dropUnique('users_email_deleted_at_unique');
            
            // Restore the original unique constraint on email
            $table->unique('email');
        });
    }
};
