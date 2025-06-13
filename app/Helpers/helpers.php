<?php
if (!function_exists('avatar_url')) {
    /**
     * Haal de volledige URL op van een avatar-bestand.
     *
     * @param \App\Models\User|null $user
     * @return string
     */
    function avatar_url(?\App\Models\User $user): string
    {
        if (!$user || !$user->avatar) {
            return asset('images/default-avatar.png'); // fallback
        }

        return asset("storage/avatars/{$user->id}/{$user->avatar}");
    }

}
