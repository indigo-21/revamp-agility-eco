<?php

namespace Database\Seeders;

use App\Models\ChargingScheme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChargingSchemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Property',
            'Measure',
        ];

        foreach ($values as $value) {
            ChargingScheme::create([
                'name' => $value,
            ]);
        }
    }
}
