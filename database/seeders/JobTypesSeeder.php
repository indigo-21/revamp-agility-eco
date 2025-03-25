<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = array(
            'QAI',
            'Surveyor',
            'Assessor',
        );

        foreach ($values as $value) {
            JobType::create([
                'type' => $value,
            ]);
        }
    }
}
