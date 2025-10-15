<?php

namespace Database\Seeders;

use App\Models\Alert;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alert::create([
            'title' => 'Severe Flood Warning',
            'message' => 'Rising water levels reported in Atani. Residents should move to higher ground.',
            'severity' => 'critical',
            'location' => 'Atani',
            'gps_lat' => 6.014226,
            'gps_lng' => 6.745682,
            'status' => true,
        ]);

        Alert::create([
            'title' => 'Flood Alert',
            'message' => 'Odekpe community experiencing minor flooding. Monitor situation closely.',
            'severity' => 'medium',
            'location' => 'Odekpe',
            'gps_lat' => 6.082210,
            'gps_lng' => 6.713540,
            'status' => true,
        ]);
    }
}
