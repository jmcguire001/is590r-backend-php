<?php

namespace Database\Seeders;

use App\Models\Sponsors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsors = [
            [
                'name' => 'Nike'
            ],
            [
                'name' => 'Adidas'
            ],
            [
                'name' => 'Under Armour'
            ],
            [
                'name' => 'Gatorade'
            ],
            [
                'name' => 'Coca-Cola'
            ],
            [
                'name' => 'Pepsi'
            ],
            [
                'name' => 'AT&T'
            ],
            [
                'name' => 'Verizon'
            ],
            [
                'name' => 'State Farm'
            ],
            [
                'name' => 'Allstate'
            ],
            [
                'name' => 'Progressive'
            ],
            [
                'name' => 'Geico'
            ],
            [
                'name' => 'Budweiser'
            ],
            [
                'name' => 'Miller Lite'
            ],
            [
                'name' => 'Heineken'
            ],
            [
                'name' => 'Monster Energy'
            ],
            [
                'name' => 'Red Bull'
            ],
            [
                'name' => 'Subway'
            ]
        ];

        Sponsors::insert(values:$sponsors);
    }
}
