<?php


use App\Http\Controllers\VehicleController;
use App\Http\Livewire\AddCar;
use App\Http\Livewire\Admin\Products;
use App\Http\Livewire\Cart;
use App\Http\Livewire\Settings\Appearance;
use App\Http\Livewire\Settings\Password;
use App\Http\Livewire\Settings\Profile;
use App\Http\Livewire\Admin\Users;
use App\Http\Livewire\Shop;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/shop', Shop::class)->name('shop');
Route::get('/cart', Cart::class)->name('cart');

Route::middleware(['auth'])->group(function () {
    Route::view('home', 'dashboard')->middleware(['verified'])->name('dashboard');
    Route::get('/voeg-auto-toe', AddCar::class)->name('add-car');
    Route::get('/kenteken/{vehicle}', [VehicleController::class, 'show'])->name('car.show');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/admin-user-panel', Users::class)->name('settings.admin_user_panel');
    Route::get('settings/admin-product-panel', Products::class)->name('settings.admin_product_panel');
});

require __DIR__.'/auth.php';
