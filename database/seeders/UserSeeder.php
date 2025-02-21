<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * *
     * * @return void
     */

    public function run(): void
    {
        $users = [
            [
                'name' => 'Jake McGuire',
                'email' => 'electric.jay11@gmail.com',
                'email_verified_at' => null,
                'password' => bcrypt('Password1'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
            
        User::insert($users);
    }
}
