<?php

namespace Database\Seeders;

use App\Models\ClientJobType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientJobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            [
                'client_id' => '1',
                'job_type_id' => '1',
            ],
            [
                'client_id' => '1',
                'job_type_id' => '2',
            ],
            [
                'client_id' => '2',
                'job_type_id' => '1',
            ],
        ];

        foreach ($values as $value) {
            ClientJobType::create([
                'client_id' => $value['client_id'],
                'job_type_id' => $value['job_type_id'],
            ]);
        }
    }
}
