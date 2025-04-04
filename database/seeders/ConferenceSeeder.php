<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Conference;

class ConferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conferences = [
            [
                'name' => 'Big XII',
                'abbr' => 'B12',
                'isPower' => true,
                'confGames' => 9,
                'divGames' => 0,
                'value' => 470
            ],
            [
                'name' => 'Mountain West',
                'abbr' => 'MW',
                'isPower' => false,
                'confGames' => 8,
                'divGames' => 0,
                'value' => 84
            ],
            [
                'name' => 'PAC-12 ',
                'abbr' => 'P12',
                'isPower' => true,
                'confGames' => 8,
                'divGames' => 0,
                'value' => 400
            ],
            [
                'name' => 'Southeastern Conference',
                'abbr' => 'SEC',
                'isPower' => true,
                'confGames' => 8,
                'divGames' => 0,
                'value' => 710
            ],
            [
                'name' => 'Atlantic Coast Conference',
                'abbr' => 'ACC',
                'isPower' => true,
                'confGames' => 9,
                'divGames' => 0,
                'value' => 553
            ],
            [
                'name' => 'Big Ten',
                'abbr' => 'B1G',
                'isPower' => true,
                'confGames' => 9,
                'divGames' => 0,
                'value' => 880
            ],
            [
                'name' => 'American Athletic Conference',
                'abbr' => 'AAC',
                'isPower' => false,
                'confGames' => 9,
                'divGames' => 0,
                'value' => 105
            ],
            [
                'name' => 'Sun Belt Conference',
                'abbr' => 'SBC',
                'isPower' => false,
                'confGames' => 9,
                'divGames' => 0,
                'value' => 14
            ],
            [
                'name' => 'Conference USA',
                'abbr' => 'CUSA',
                'isPower' => false,
                'confGames' => 8,
                'divGames' => 0,
                'value' => 21
            ],
            [
                'name' => 'Mid-American Conference',
                'abbr' => 'MAC',
                'isPower' => false,
                'confGames' => 8,
                'divGames' => 0,
                'value' => 53
            ]
        ];

        Conference::insert($conferences);
    }
}