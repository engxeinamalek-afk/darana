<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\City;
use App\Models\Owner;
use App\Models\Property;
use App\Enums\PropertyStatus;
use App\Enums\PropertyTypes;
use App\Enums\CurrencyTypes;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'office_id' => User::where('role', 'office')->inRandomOrder()->first()?->id 
                           ?? User::factory()->office(),

            'city_id' => City::inRandomOrder()->first()?->id 
                         ?? City::factory(),

            'owner_id' => Owner::inRandomOrder()->first()?->id 
                          ?? Owner::factory(),
            
            'status' => fake()->randomElement(PropertyStatus::cases()),
            'type' => fake()->randomElement(PropertyTypes::cases()),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'is_featured' => fake()->boolean(5),
            'price' => fake()->numberBetween(150000000, 950000000),
            'currency' => fake()->randomElement(CurrencyTypes::cases()),
            'internal_notes' => fake()->optional()->text(),
            'commission_rate' => fake()->randomFloat(2, 1.00, 5.00),
        ];
    }
}
