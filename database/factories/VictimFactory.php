<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Victim>
 */
class VictimFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('en_NG');

        // Rough geographic bounding box for Anambra & Enugu
        $minLat = 5.9;   // Southern edge near Ogbaru
        $maxLat = 6.9;   // Northern edge near Nsukka
        $minLng = 6.7;   // Western edge near Onitsha
        $maxLng = 7.6;   // Eastern edge near Enugu

        return [
            'name' => $faker->name,
            'age' => $faker->numberBetween(1, 90),
            'gender' => $faker->randomElement(['male', 'female']),
            'contact' => $faker->unique()->numerify('080########'),
            'location' => $faker->randomElement(['Atani', 'Odekpe', 'Osomala', 'Ogwuikpele', 'Onitsha', 'Awka', 'Enugu', 'Nsukka']),
            'latitude' => $faker->randomFloat(6, $minLat, $maxLat),
            'longitude' => $faker->randomFloat(6, $minLng, $maxLng),
            'safe_zone_id' => \App\Models\SafeZone::inRandomOrder()->first()?->id,
        ];
    }
}
