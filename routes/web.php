<?php


use App\Http\Controllers\VehicleController;
use App\Http\Livewire\AddCar;
use App\Http\Livewire\Admin\Products;
use App\Http\Livewire\Cart;
use App\Http\Livewire\Checkout;
use App\Http\Livewire\Checkout\Billing;
use App\Http\Livewire\Checkout\Payment;
use App\Http\Livewire\Checkout\Shipping;
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

Route::middleware(['auth'])->group(function () {
    Route::view('home', 'dashboard')->middleware(['verified'])->name('dashboard');

//    Car
    Route::get('/voeg-auto-toe', AddCar::class)->name('add-car');
    Route::get('/kenteken/{vehicle}', [VehicleController::class, 'show'])->name('car.show');

//    Shopping Cart
    Route::get('/cart', Cart::class)->name('cart');

    Route::prefix('checkout')
//        ->middleware('cart.notempty')
        ->group(function () {
            Route::get('/billing', Billing::class)->name('checkout.billing');
            Route::get('/shipping', Shipping::class)->name('checkout.shipping');
            Route::get('/payment', Payment::class)->name('checkout.payment');
        });

//    Settings
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/admin-user-panel', Users::class)->name('settings.admin_user_panel');
    Route::get('settings/admin-product-panel', Products::class)->name('settings.admin_product_panel');
});

require __DIR__.'/auth.php';
