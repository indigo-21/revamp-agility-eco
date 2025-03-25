<?php

namespace Database\Seeders;

use App\Models\Installer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstallerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = array(
            [
                'name' => 'ZZ Test Installer',
                'email' => 'james.zarsuelo@indigo21.com',
                'contact_number' => '447810897005',
            ],
            [
                'name' => 'Acme Installers Ltd',
                'email' => 'james.zarsuelo1@indigo21.com',
                'contact_number' => '447810897005',
            ],
            [
                'name' => '0800 Repair',
                'email' => 'james.zarsuelo2@indigo21.com',
                'contact_number' => '01792447740',
            ],
            [
                'name' => 'A&D Carbon Solutions',
                'email' => 'james.zarsuelo3@indigo21.com',
                'contact_number' => ' 141 881 9519',
            ],
        );

        foreach ($values as $value) {
            Installer::create([
                'name' => $value['name'],
                'email' => $value['email'],
                'contact_number' => $value['contact_number'],
            ]);
        }
    }
}
