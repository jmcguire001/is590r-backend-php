<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StadiumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stadiums = 
        [
            [
                'name' => 'LaVell Edwards Stadium'
            ],
            [
                'name' => 'Rice-Eccles Stadium'
            ],
            [
                'name' => 'Albertsons Stadium'
            ],
            [
                'name' => 'War Memorial Stadium'
            ],
            [
                'name' => 'Maverik Stadium'
            ]
        ];

        foreach ($stadiums as $stadium) {
            DB::table('stadiums')->insert([
                'name' => $stadium['name']
            ]);
        }
    }
}
