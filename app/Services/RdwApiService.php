<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RdwApiService
{
    protected string $baseUrl = 'https://opendata.rdw.nl/resource/m9d7-ebf2.json';

    /**
     * Fetches license plate data from an external API based on the provided license plate string.
     *
     * @param string $kenteken The license plate string to query, cleaned and converted to uppercase.
     * @return array|null The license plate data if the API call is successful and data is available, otherwise null.
     */
    public function getLicensePlateData(string $kenteken): ?array
    {
        $response = Http::get($this->baseUrl, [
            'kenteken' => strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $kenteken)),
        ]);

        if ($response->successful() && !empty($response[0])) {
            return $response[0];
        }

        return null;
    }

    /**
     * Retrieves the fuel type for a given vehicle based on the provided license plate.
     *
     * @param string $kenteken The license plate of the vehicle.
     * @return string|null Returns the fuel type description if found, otherwise null.
     */
    public function getFuelType(string $kenteken): ?string
    {
        $response = Http::get('https://opendata.rdw.nl/resource/8ys7-d773.json', [
            'kenteken' => strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $kenteken)),
        ]);

        if ($response->successful() && !empty($response[0])) {
            return $response[0]['brandstof_omschrijving'] ?? null;
        }

        return null;
    }

}
