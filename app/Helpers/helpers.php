<?php

use App\Http\Controllers\VehicleController;
use App\Livewire\Car\CarData;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('avatar_url')) {
    /**
     * Retrieves and returns the URL for a user's avatar.
     * If the specified user does not have an avatar or the provided user ID is invalid,
     * a default placeholder image is returned. If no avatar exists in storage, an empty string is returned.
     *
     * @param int $userId The ID of the user. Defaults to 0.
     * @return string The URL of the user's avatar, a default placeholder image, or an empty string.
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
     * Generates and returns the URL for a product image.
     * If the specified product does not exist or the image path does not exist in storage,
     * a default application image is returned.
     *
     * @param int $productId The ID of the product. Defaults to 0.
     * @return string The URL of the product image or a default image.
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


if (!function_exists('saveFileSafely')) {
    /**
     * Saves an uploaded file to a specified folder with a safe, unique name.
     *
     * Determines the folder to use based on the provided user ID or product ID.
     * If neither is provided, a general folder is used. The file is renamed
     * using a slugified version of its original name, appended with a unique identifier.
     *
     * @param UploadedFile $file The file being uploaded.
     * @param int|null $userId Optional user ID, used to organize user-specific files.
     * @param string $folder The base folder where the file will be stored. Defaults to 'uploads'.
     * @param int|null $productId Optional product ID, used to organize product-specific files.
     *
     * @return string The unique name of the safely stored file.
     */
    function saveFileSafely(UploadedFile $file, ?int $userId = null, string $folder = 'uploads', ?int $productId = null): string
    {
        if ($userId) {
            // User bestanden (avatars)
            $baseFolder = "{$userId}/{$folder}";
        } else if ($productId) {
            // Product bestanden
            $baseFolder = "{$folder}/{$productId}";
        } else {
            // Algemeen
            $baseFolder = $folder;
        }

        // Veilige bestandsnaam genereren
        $safeName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = $file->getClientOriginalExtension();
        $uniqueName = $safeName . '-' . uniqid() . '.' . $extension;

        // Opslaan
        $file->storeAs($baseFolder, $uniqueName, 'public');

        return $uniqueName;
    }
}


if (!function_exists('formatLabel')) {
    /**
     * Formats the given key into a user-friendly label by replacing underscores with spaces
     * and converting the text to title case.
     *
     * @param string $key The key to be formatted.
     * @return string The formatted label.
     */
    function formatLabel(string $key): string
    {
        return (string)Str::of($key)->replace('_', ' ')->title();
    }
}


if (!function_exists('formatFieldValue')) {
    /**
     * Formats a given field value based on its type and predefined criteria.
     *
     * - If the field is recognized as a date, attempts to parse and format it as 'd-m-Y'.
     * - If parsing the date fails, logs a warning and returns the original value.
     * - If the value is numeric, processes it further using a custom numeric formatter.
     * - Returns the original value for all other cases.
     *
     * @param string $key The name of the field.
     * @param mixed $value The value associated with the field.
     * @return mixed The formatted value or the original value if no formatting is applied.
     */
    function formatFieldValue(string $key, mixed $value): mixed
    {
        $isDateField = Str::endsWith($key, CarData::DATE_SUFFIXES) || Str::startsWith($key, CarData::DATE_PREFIXES);

        if ($isDateField && $value) {
            try {
                return Carbon::parse($value)->format('d-m-Y');
            } catch (Exception $e) {
                Log::warning(
                    "Failed to parse date value for key '{$key}': {$value}",
                    ['exception' => $e->getMessage()]
                );

                return $value;
            }
        }

        if (is_numeric($value)) {
            return formatNumericValue($key, (float)$value);
        }

        return $value;
    }
}


if (!function_exists('formatNumericValue')) {
    /**
     * Formats a numeric value based on the specified key's category (e.g., currency, weight, volume, speed, or power).
     *
     * @param string $key The field key used to determine the formatting rules.
     * @param float $value The numeric value to format.
     * @return string The formatted numeric value with appropriate units or symbols.
     */
    function formatNumericValue(string $key, float $value): string
    {
        if (Str::contains($key, CarData::CURRENCY_KEYS)) {
            return '€ ' . number_format($value, 0, '.', ',');
        }

        if (Str::contains($key, CarData::WEIGHT_KEYS)) {
            return number_format($value, 0, ',', ',') . ' ' . __('kg');
        }

        if (Str::contains($key, CarData::VOLUME_KEYS)) {
            return number_format($value, 0, ',', ',') . ' ' . __('cc');
        }

        if (Str::contains($key, CarData::SPEED_KEYS)) {
            return number_format($value, 0, ',', ',') . ' ' . __('km/u');
        }

        if (Str::contains($key, CarData::POWER_KEYS)) {
            return number_format($value, 0, ',', ',') . ' ' . __('kW');
        }

        return number_format($value, 0, ',', ',');
    }
}

