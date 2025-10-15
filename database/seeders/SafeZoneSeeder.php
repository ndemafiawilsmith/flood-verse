<?php

namespace Database\Seeders;

use App\Models\SafeZone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SafeZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SafeZone::factory(20)->create();
        //  SafeZone::create([
        //     'name' => 'Atani Community Secondary School',
        //     'address' => 'Atani, Ogbaru, Anambra',
        //     'gps_lat' => 5.998368684553804, //5.998368684553804, 6.745374012203959
        //     'gps_lng' => 6.745374012203959,
        //     'capacity' => 500,
        // ]);

        // SafeZone::create([
        //     'name' => 'St. Patrick Catholic Church',
        //     'address' => 'Osomala, Ogbaru, Anambra',
        //     'gps_lat' => 6.046010,
        //     'gps_lng' => 6.731900,
        //     'capacity' => 350,
        // ]);

        // SafeZone::create([
        //     'name' => 'Odekpe Town Hall',
        //     'address' => 'Odekpe, Ogbaru, Anambra',
        //     'gps_lat' => 6.082210,
        //     'gps_lng' => 6.713540,
        //     'capacity' => 400,
        // ]);
    }
}
