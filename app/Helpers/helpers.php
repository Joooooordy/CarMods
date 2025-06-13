<?php

use App\Models\User;
use Illuminate\Support\Facades\Storage;

if (!function_exists('avatar_url')) {
    /**
     * Haal de volledige URL op van een avatar-bestand.
     *
     * @param User|null $user
     * @return string
     */
    function avatar_url(?User $user): string
    {
        if (!$user || !$user->avatar) {
            return '';
        }

        $path = "public/avatars/{$user->id}/{$user->avatar}";

        if (Storage::exists($path)) {
            return asset("storage/avatars/{$user->id}/{$user->avatar}");
        }

        return asset('img/empty-user.svg');
    }
}
