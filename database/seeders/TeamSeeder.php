<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'teamName' => 'Brigham Young University',
                'teamAbbr' => 'BYU',
                'teamLogo' => 'images/byu.png',
                'teamConference' => 'Big XII',
                'teamDivision' => '',
                'teamCity' => 'Provo',
                'teamState' => 'Utah',
                'teamCountry' => 'USA',
                'teamStadium' => 'LaVell Edwards Stadium',
                'teamMascot' => 'Cougars'
            ],
            [
                'teamName' => 'University of Utah',
                'teamAbbr' => 'Utah',
                'teamLogo' => 'images/utah.jpg',
                'teamConference' => 'Big XII',
                'teamDivision' => '',
                'teamCity' => 'Salt Lake City',
                'teamState' => 'Utah',
                'teamCountry' => 'USA',
                'teamStadium' => 'Rice-Eccles Stadium',
                'teamMascot' => 'Utes'
            ],
            [
                'teamName' => 'Utah State University',
                'teamAbbr' => 'USU',
                'teamLogo' => 'images/usu.png',
                'teamConference' => 'Mountain West',
                'teamDivision' => '',
                'teamCity' => 'Logan',
                'teamState' => 'Utah',
                'teamCountry' => 'USA',
                'teamStadium' => 'Merlin Olsen Field at Maverik Stadium',
                'teamMascot' => 'Aggies'
            ],
            [
                'teamName' => 'Boise State University',
                'teamAbbr' => 'BSU',
                'teamLogo' => 'images/bsu.png',
                'teamConference' => 'Mountain West',
                'teamDivision' => 'Mountain',
                'teamCity' => 'Boise',
                'teamState' => 'Idaho',
                'teamCountry' => 'USA',
                'teamStadium' => 'Albertsons Stadium',
                'teamMascot' => 'Broncoss'
            ],
            [
                'teamName' => 'Wyoming University',
                'teamAbbr' => 'WYO',
                'teamLogo' => 'images/wyo.png',
                'teamConference' => 'Mountain West',
                'teamDivision' => 'Mountain',
                'teamCity' => 'Laramie',
                'teamState' => 'Wyoming',
                'teamCountry' => 'USA',
                'teamStadium' => 'War Memorial Stadium',
                'teamMascot' => 'Cowboys'
            ]
        ];

        Team::insert(values:$teams);
    }
}