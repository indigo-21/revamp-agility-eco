<?php

namespace Database\Seeders;

use App\Models\UserNavigation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserNavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [];
        for ($i = 1; $i <= 38; $i++) {
            if ($i != 33 && $i != 38 && $i != 39 ) {
                $values[] = [
                    'account_level_id' => 1,
                    'navigation_id' => $i,
                    'permission' => 3,
                ];
            }
        }

        $values[] = [
            'account_level_id' => 5,
            'navigation_id' => 42,
            'permission' => 3,
        ];
        $values[] = [
            'account_level_id' => 5,
            'navigation_id' => 30,
            'permission' => 1,
        ];
        $values[] = [
            'account_level_id' => 5,
            'navigation_id' => 33,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 6,
            'navigation_id' => 38,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 7,
            'navigation_id' => 38,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 8,
            'navigation_id' => 38,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 6,
            'navigation_id' => 39,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 7,
            'navigation_id' => 39,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 8,
            'navigation_id' => 39,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 6,
            'navigation_id' => 26,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 7,
            'navigation_id' => 26,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 8,
            'navigation_id' => 26,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 6,
            'navigation_id' => 27,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 7,
            'navigation_id' => 27,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 8,
            'navigation_id' => 27,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 6,
            'navigation_id' => 28,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 7,
            'navigation_id' => 28,
            'permission' => 3,
        ];

        $values[] = [
            'account_level_id' => 8,
            'navigation_id' => 28,
            'permission' => 3,
        ];

        foreach ($values as $value) {
            UserNavigation::create([
                'account_level_id' => $value['account_level_id'],
                'navigation_id' => $value['navigation_id'],
                'permission' => $value['permission'],
            ]);
        }
    }
}
