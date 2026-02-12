<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure the navigation item exists (for existing DBs that won't re-run seeders).
        $navigation = DB::table('navigations')->where('link', 'navigation-audit-log')->first();

        if (!$navigation) {
            $id = (int) (DB::table('navigations')->max('id') ?? 0) + 1;

            $platformConfigId = (int) (DB::table('navigations')
                ->where('name', 'Platform Configuration')
                ->value('id') ?? 0);

            DB::table('navigations')->insert([
                'id' => $id,
                'name' => 'Navigation Audit Logs',
                'link' => 'navigation-audit-log',
                'icon' => 'history',
                'has_dropdown' => 0,
                'parent_id' => $platformConfigId > 0 ? $platformConfigId : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $navigationId = $id;
        } else {
            $navigationId = (int) $navigation->id;
        }

        // Grant ONLY account_level_id=1 access.
        $existingPermission = DB::table('user_navigations')
            ->where('account_level_id', 1)
            ->where('navigation_id', $navigationId)
            ->whereNull('deleted_at')
            ->first();

        if (!$existingPermission) {
            DB::table('user_navigations')->insert([
                'account_level_id' => 1,
                'navigation_id' => $navigationId,
                'permission' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $navigation = DB::table('navigations')->where('link', 'navigation-audit-log')->first();
        if (!$navigation) {
            return;
        }

        DB::table('user_navigations')
            ->where('navigation_id', $navigation->id)
            ->delete();

        DB::table('navigations')
            ->where('id', $navigation->id)
            ->delete();
    }
};
