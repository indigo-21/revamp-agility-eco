<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = array(
            [
                'firstname' => 'James',
                'lastname' => 'Zarsuelo',
                'email' => 'james.zarsuelo@indigo21.com',
                'organisation' => 'Agility Eco',
                'mobile' => '09362252822',
                'landline' => null,
                'otp' => null,
                'account_level_id' => 1,
                'user_type_id' => 6,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make('indigo21'),
            ],
            [
                'firstname' => 'Andy',
                'lastname' => 'Sumpter',
                'email' => 'andy.sumpter@contactone.net',
                'organisation' => 'Agility Eco',
                'mobile' => '09362252822',
                'landline' => null,
                'otp' => null,
                'account_level_id' => 1,
                'user_type_id' => 6,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make('password'),
            ],
        );

        foreach ($values as $value) {
            User::create([
                'firstname' => $value['firstname'],
                'lastname' => $value['lastname'],
                'email' => $value['email'],
                'organisation' => $value['organisation'],
                'mobile' => $value['mobile'],
                'landline' => $value['landline'],
                'otp' => $value['otp'],
                'account_level_id' => $value['account_level_id'],
                'user_type_id' => $value['user_type_id'],
                'email_verified_at' => $value['email_verified_at'],
                'password' => $value['password'],

            ]);
        }
    }
}