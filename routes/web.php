<?php

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', Home::class)->name('home');
