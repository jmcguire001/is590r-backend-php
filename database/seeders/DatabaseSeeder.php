<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team;
use App\Models\Conference;
use App\Models\Division;
use App\Models\ConferenceDivision;
use App\Models\Sponsors;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * @return void
     */

    public function run(): void
    {
        // This seeder is the parent seeder that calls all other seeders
        // Make sure order of other seeders is correct
        
        $this->call([
            UserSeeder::class,
            ConferenceSeeder::class,
            DivisionSeeder::class,
            ConferenceDivisionSeeder::class,
            TeamSeeder::class,
            SponsorSeeder::class,
            TeamSponsorsSeeder::class
        ]);
    }
}
