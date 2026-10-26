<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $syrianGovernorates = [
            'Damascus',
            'Rif Dimashq',
            'Aleppo',
            'Homs',
            'Hama',
            'Latakia',
            'Tartus',
            'Idlib',
            'Deir ez-Zor',
            'Raqqa',
            'Hasakah',
            'Daraa',
            'Suwayda',
            'Quneitra'
        ];

        foreach ($syrianGovernorates as $governorate) {
            City::firstOrCreate(['name' => $governorate]);
        }
    }
}
