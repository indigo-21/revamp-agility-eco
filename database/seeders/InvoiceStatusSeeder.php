<?php

namespace Database\Seeders;

use App\Models\InvoiceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Not Invoiceable',
            'Invoiced',
        ];

        foreach ($statuses as $status) {
            InvoiceStatus::create(['name' => $status]);
        }
    }
}
