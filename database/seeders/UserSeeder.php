<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Image;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(5)
            ->office()
            ->create()
            ->each(function ($office) {
                Image::factory()->create([
                    'imageable_id' => $office->id,
                    'imageable_type' => 'office',
                ]);
            });


        User::factory()->count(50)->create();
    }
}
