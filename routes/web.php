<?php


use App\Livewire\Car\CarData;
use App\Livewire\Cart\Cart;
use App\Livewire\Checkout\Billing;
use App\Livewire\Checkout\Confirmed\OrderConfirmed;
use App\Livewire\Checkout\Payment;
use App\Livewire\Checkout\Shipping;
use App\Livewire\SearchCar;
use App\Livewire\Settings\Admin\Orders;
use App\Livewire\Settings\Admin\Products;
use App\Livewire\Settings\Admin\Users;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Order\OrderDetails;
use App\Livewire\Settings\Order\UserOrder;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\UserVehicle;
use App\Livewire\Shop;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/shop', Shop::class)->name('shop');

Route::middleware(['auth'])->group(function () {
    Route::view('home', 'dashboard')->middleware(['verified'])->name('dashboard');

    //Car
    Route::get('/search-car', SearchCar::class)->name('search-car');
    Route::get('/licenseplate/{vehicle}', CarData::class)->name('car-data');

    //Shopping Cart
    Route::get('/cart', Cart::class)->name('cart');

    Route::prefix('checkout')
        ->middleware('cart.notempty')
        ->group(function () {
            Route::get('/billing', Billing::class)->name('checkout.billing');
            Route::get('/shipping', Shipping::class)->name('checkout.shipping');
            Route::get('/payment', Payment::class)->name('checkout.payment');
        });

    Route::get('/order-confirmed', OrderConfirmed::class)->name('order-confirmed')->middleware('has.recent.order');;

    //Settings
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('settings/orders', UserOrder::class)->name('settings.user-orders');
    Route::get('settings/orders/{order}/details', OrderDetails::class)->name('settings.user-order-details');
    Route::get('settings/vehicles', UserVehicle::class)->name('settings.user-vehicles');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('settings/admin-user-panel', Users::class)->name('settings.admin_user_panel');
        Route::get('settings/admin-product-panel', Products::class)->name('settings.admin_product_panel');
        Route::get('settings/admin-order-panel', Orders::class)->name('settings.admin_order_panel');
    });
});

require __DIR__.'/auth.php';
