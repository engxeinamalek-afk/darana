<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Image;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Property::factory()
            ->count(1000)
            ->create()
            ->each(function ($property) {
                Image::factory()
                    ->count(rand(2, 4)) 
                    ->create([
                        'imageable_id'   => $property->id,
                        'imageable_type' => 'property',
                    ]);
                    
            });
    }
}
