<?php

use App\Http\Controllers\AddCarController;
use App\Http\Livewire\Settings\Appearance;
use App\Http\Livewire\Settings\Password;
use App\Http\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::view('home', 'dashboard')->middleware(['verified'])->name('dashboard');
    Route::view('voeg-auto-toe', 'add_car')->name('add-car');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
