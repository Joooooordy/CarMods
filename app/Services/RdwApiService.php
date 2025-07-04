<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RdwApiService
{
    protected string $baseUrl = 'https://opendata.rdw.nl/resource/m9d7-ebf2.json';

    /**
     * Haal voertuiggegevens op van RDW API op basis van kenteken.
     * @param string $kenteken
     * @return array|null
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
