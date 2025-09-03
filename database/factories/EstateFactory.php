<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estate>
 */
class EstateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'title' => fake()->words(3, true),               
            'description' => fake()->paragraph(),            
            'price' => fake()->numberBetween(50000, 1000000),
            'address' => fake()->city(),                  
            'location' => [
                'lat' => fake()->latitude(),
                'lon' => fake()->longitude(),
            ],                    
            'area' => fake()->numberBetween(50, 500),
            'listing_type' => fake()->boolean(70) ? 'rent' : 'sale',
            'image' => 'public/images/876d2bf7118a02fd783885e32280c0e3dd96fcfd.jpg',
            'other_data' => [
                'rooms_count' => 3
            ],
            'estate_type' => Arr::random(['villa','land','flat','house','other'])
        ];
    }
}
