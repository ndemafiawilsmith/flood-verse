<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SafeZone>
 */
class SafeZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Rough bounding box covering Anambra + Enugu
        $minLat = 5.9;   // southern edge
        $maxLat = 6.9;   // northern edge
        $minLng = 6.7;   // western edge
        $maxLng = 7.6;   // eastern edge

        return [
            'name' => fake()->company(),
            'latitude' => fake()->randomFloat(6, $minLat, $maxLat),
            'longitude' => fake()->randomFloat(6, $minLng, $maxLng),
            'description' => fake()->paragraph(),
        ];
    }
}
