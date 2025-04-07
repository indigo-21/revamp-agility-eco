<?php

namespace Database\Seeders;

use App\Models\AccountLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Admin',
            'Agent',
            'User',
            'Client',
            'Installer',
            'Firm Property Inspector',
            'Employed Property Inspector',
            'Freelance Property Inspector',

        ];

        foreach ($values as $value) {
            AccountLevel::create([
                'name' => $value,
            ]);
        }
    }
}


