<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(640, 480, 'real estate', true),
            'rooms' => $this->faker->numberBetween(1, 5),
            'floor' => $this->faker->numberBetween(1, 20),
            'area' => $this->faker->numberBetween(30, 300),
            'description' => $this->faker->paragraph,
        ];
    }
}
