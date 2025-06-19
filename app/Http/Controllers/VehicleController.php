<?php

namespace App\Http\Controllers;

use App\Models\Kenteken;
use App\Services\RdwApiService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    /**
     * Toon details van een voertuig.
     *
     * @param  Kenteken  $vehicle
     * @return Factory|View|Application|object
     */
    public function show($vehicle)
    {
        $car = Kenteken::where('licenseplate', $vehicle)->first();

        if (!$car) {
            return redirect()->back()->with('error', 'Voertuig niet gevonden.');
        }

        return view('livewire.car.car_data', [
            'vehicleData' => $car->data,
            'formattedLicensePlate' => $car->formatted_licenseplate,
        ]);
    }
}
