<?php

use App\Models\User;
use Illuminate\Support\Facades\Log;
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

        $path = "avatars/{$user->id}/{$user->avatar}";

        if (Storage::disk('public')->exists($path)) {
            return asset("storage/avatars/{$user->id}/{$user->avatar}");
        }

        return asset('img/empty-user.svg');
    }
}
