<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // 🔐 Auto-create a default judge account if it doesn't exist
    if (!User::where('email', 'judge@floodverse.com')->exists()) {
        User::create([
            'name' => 'FloodVerse Judge',
            'email' => 'judge@floodverse.com',
            'password' => Hash::make('judge1234'),
        ]);
    }
    }
}
