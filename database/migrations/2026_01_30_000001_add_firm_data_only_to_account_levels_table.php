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
        Schema::table('account_levels', function (Blueprint $table) {
            if (!Schema::hasColumn('account_levels', 'firm_data_only')) {
                $table->boolean('firm_data_only')->default(false)->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_levels', function (Blueprint $table) {
            if (Schema::hasColumn('account_levels', 'firm_data_only')) {
                $table->dropColumn('firm_data_only');
            }
        });
    }
};
