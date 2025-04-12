<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSponsorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teamSponsors = [
            [
                'teamId' => 1,
                'sponsorId' => 1
            ],
            [
                'teamId' => 1,
                'sponsorId' => 4
            ],
            [
                'teamId' => 1,
                'sponsorId' => 8
            ],
            [
                'teamId' => 2,
                'sponsorId' => 3
            ],
            [
                'teamId' => 2,
                'sponsorId' => 4
            ],
            [
                'teamId' => 2,
                'sponsorId' => 11
            ],
            [
                'teamId' => 3,
                'sponsorId' => 1
            ],
            [
                'teamId' => 3,
                'sponsorId' => 15
            ],
            [
                'teamId' => 3,
                'sponsorId' => 18
            ],
            [
                'teamId' => 3,
                'sponsorId' => 12
            ],
            [
                'teamId' => 4,
                'sponsorId' => 2
            ],
            [
                'teamId' => 4,
                'sponsorId' => 7
            ],
            [
                'teamId' => 5,
                'sponsorId' => 1
            ],
            [
                'teamId' => 5,
                'sponsorId' => 9
            ]
        ];

        foreach ($teamSponsors as $teamSponsor) {
            DB::table('team_sponsors')->insert([
                'teamId' => $teamSponsor['teamId'],
                'sponsorId' => $teamSponsor['sponsorId']
            ]);
        }
    }
}
