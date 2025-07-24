<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

if (!function_exists('avatar_url')) {
    /**
     * Haal de volledige URL op van een avatar-bestand.
     *
     * @param int $userId
     * @return string
     */
    function avatar_url(int $userId = 0): string
    {
        $user = User::where('id', auth()->user()->id)->first();

        if (!$userId || !$user->avatar) {
            return '';
        }

        $path = "{$user->id}/avatars/{$user->avatar}";

        if (Storage::disk('public')->exists($path)) {
            return asset("storage/{$user->id}/avatars/{$user->avatar}");
        }

        return asset('img/empty-user.svg');
    }
}

if (!function_exists('image_url')) {
    /**
     * Haal de volledige URL op van een product-bestand.
     *
     * @param int $productId
     * @return string
     */
    function image_url(int $productId = 0): string
    {
        $user = auth()->user();
        $product = Product::where('id', $productId)->first();

        if (!$product) {
            return asset('img/CarMods.svg');
        }

        $path = "{$user->id}/products/{$productId}/{$product->image}";

        if (Storage::disk('public')->exists($path)) {
            return asset("storage/{$path}");
        }

        return asset('img/CarMods.svg');
    }
}

