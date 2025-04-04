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
                'name' => 'Brigham Young University',
                'abbr' => 'BYU',
                'logo' => 'images/byu.png',
                'confId' => 1,
                'divId' => null,
                'city' => 'Provo',
                'state' => 'Utah',
                'country' => 'USA',
                'stadium' => 'LaVell Edwards Stadium',
                'mascot' => 'Cougars'
            ],
            [
                'name' => 'University of Utah',
                'abbr' => 'Utah',
                'logo' => 'images/utah.jpg',
                'confId' => 1,
                'divId' => null,
                'city' => 'Salt Lake City',
                'state' => 'Utah',
                'country' => 'USA',
                'stadium' => 'Rice-Eccles Stadium',
                'mascot' => 'Utes'
            ],
            [
                'name' => 'Utah State University',
                'abbr' => 'USU',
                'logo' => 'images/usu.png',
                'confId' => 2,
                'divId' => null,
                'city' => 'Logan',
                'state' => 'Utah',
                'country' => 'USA',
                'stadium' => 'Merlin Olsen Field at Maverik Stadium',
                'mascot' => 'Aggies'
            ],
            [
                'name' => 'Boise State University',
                'abbr' => 'BSU',
                'logo' => 'images/bsu.jpg',
                'confId' => 2,
                'divId' => null,
                'city' => 'Boise',
                'state' => 'Idaho',
                'country' => 'USA',
                'stadium' => 'Albertsons Stadium',
                'mascot' => 'Broncos'
            ],
            [
                'name' => 'Wyoming University',
                'abbr' => 'WYO',
                'logo' => 'images/wyo.png',
                'confId' => 2,
                'divId' => null,
                'city' => 'Laramie',
                'state' => 'Wyoming',
                'country' => 'USA',
                'stadium' => 'War Memorial Stadium',
                'mascot' => 'Cowboys'
            ]
        ];

        Team::insert(values:$teams);
    }
}