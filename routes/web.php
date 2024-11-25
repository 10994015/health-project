<?php

use App\Livewire\Cms\CommentComponent;
use App\Livewire\Cms\DashboardComponent;
use App\Livewire\Cms\FeedbackComponent;
use App\Livewire\Cms\LotteryComponent;
use App\Livewire\FinishComponent;
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
Route::get('/3kjF66lVgrnQOZCoVY3nGdkBVm9cPKOIhaFw54FmLSxYwSITYn /{signedurl}', GameComponent::class)->name('game');
Route::get('/9omZdHj08tgwIOea1jHmosFIBG9SaNtKIMFe39DbaO957iqizx/{type}/{signedurl}', InputComponent::class)->name('input');
Route::get('/HlzqfWCyRvgd35aD6T0ZiUZFATGgPEkEOteClUSi183G4vXnLo', FinishComponent::class)->name('finish');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('1HdZYqhmAeUMnUGQzSvBaVneTx8ajlNc6URspWrXmIqNmFyYcD/')->name('cms.')->group(function () {
        Route::get('/dashboard', DashboardComponent::class)->name('dashboard');
        Route::get('/lottery', LotteryComponent::class)->name('lottery');
        Route::get('/feedback', FeedbackComponent::class)->name('feedback');
        Route::get('/comment', CommentComponent::class)->name('comment');
    });
});


URL::forceScheme('https');
