<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // ✅ Create a default Filament login account for judges
        User::updateOrCreate(
            ['email' => 'judge@floodverse.com'],
            [
                'name' => 'FloodVerse Judge',
                'password' => Hash::make('judge1234'), // change this before deploying!
            ]
        );
    }
}
