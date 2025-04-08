<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            [
                'name' => 'East'
            ],
            [
                'name' => 'West'
            ],
            [
                'name' => 'North'
            ],
            [
                'name' => 'South'
            ],
            [
                'name' => 'Atlantic'
            ],
            [
                'name' => 'Coastal'
            ],
            [
                'name' => 'Mountain'
            ]
        ];
        Division::insert($divisions);
    }
}
