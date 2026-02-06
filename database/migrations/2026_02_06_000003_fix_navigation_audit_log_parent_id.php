<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $audit = DB::table('navigations')->where('link', 'navigation-audit-log')->first();
        if (!$audit) {
            return;
        }

        $platformConfig = DB::table('navigations')
            ->where('name', 'Platform Configuration')
            ->first();

        if (!$platformConfig) {
            return;
        }

        DB::table('navigations')
            ->where('id', $audit->id)
            ->update([
                'parent_id' => (int) $platformConfig->id,
                'updated_at' => now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Best-effort: detach from parent.
        $audit = DB::table('navigations')->where('link', 'navigation-audit-log')->first();
        if (!$audit) {
            return;
        }

        DB::table('navigations')
            ->where('id', $audit->id)
            ->update([
                'parent_id' => null,
                'updated_at' => now(),
            ]);
    }
};
