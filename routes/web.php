<?php

use App\Livewire\GameComponent;
use App\Livewire\HomeComponent;
use App\Livewire\InputComponent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomeComponent::class)->name('home');
Route::get('/7f15fa95/{type}/{signedurl}', GameComponent::class)->name('game');
Route::get('/3e8r5esa/{type}/{signedurl}', InputComponent::class)->name('input');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
