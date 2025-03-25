<?php

namespace Database\Seeders;

use App\Models\ClientType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = array(
            'Audit Company',
            'Private',
            'Survey Company',
        );

        foreach ($values as $value) {
            ClientType::create([
                'name' => $value,
            ]);
        }
    }
}
