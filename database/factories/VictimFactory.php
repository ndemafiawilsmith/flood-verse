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

        // Use Nigerian locale faker
        $faker = \Faker\Factory::create('en_NG');
        return [
            'name' => $faker->name,
            'age' => $faker->numberBetween(1, 90),
            'gender' => $faker->randomElement(['male', 'female']),
            'contact' => $faker->phoneNumber,
            'location' => $faker->randomElement(['Atani', 'Odekpe', 'Osomala', 'Ogwuikpele']),
            'safe_zone_id' => \App\Models\SafeZone::inRandomOrder()->first()?->id,
        ];
    }
}
