<?php

namespace Database\Seeders;

use App\Models\ConferenceDivision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConferenceDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conferenceDivisions = [
            [
                'confId' => 3,
                'divId' => 3
            ],
            [
                'confId' => 3,
                'divId' => 4
            ],
            [
                'confId' => 2,
                'divId' => 7
            ],
            [
                'confId' => 2,
                'divId' => 2
            ],
            [
                'confId' => 4,
                'divId' => 1
            ],
            [
                'confId' => 4,
                'divId' => 2
            ],
            [
                'confId' => 5,
                'divId' => 5
            ],
            [
                'confId' => 5,
                'divId' => 6
            ]
        ];

        ConferenceDivision::insert($conferenceDivisions);
    }
}
