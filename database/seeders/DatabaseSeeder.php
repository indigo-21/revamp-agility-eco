<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            ChargingSchemeSeeder::class,
            ClientTypesSeeder::class,
            JobTypesSeeder::class,
            // ClientSeeder::class,
            // ClientJobTypeSeeder::class,
            // SurveyQuestionSetSeeder::class,
            // SchemeSeeder::class,
            // InstallerSeeder::class,
            MeasureSeeder::class,
            JobStatusSeeder::class,
            AccountLevelSeeder::class,
            UserTypeSeeder::class,
            UserSeeder::class,
            OutwardPostcodeSeeder::class,
            NavigationSeeder::class,
            UserNavigationSeeder::class,
        ]);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
