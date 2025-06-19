<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Services\RdwApiService;
use App\Models\Kenteken;

class AddCar extends Component
{
    public string $licensePlate = '';
    public array $vehicleData = [];
    public string $message = '';
    public string $vehicleLicense = '';

    protected RdwApiService $rdwApi;

    public function lookupPlate()
    {
        $this->validate([
            'licensePlate' => 'required|string|max:8|min:6',
        ]);

        $this->rdwApi = app(RdwApiService::class);
        $data = $this->rdwApi->getLicensePlateData($this->licensePlate);

        if ($data) {
            $this->vehicleData = json_decode(json_encode($data), true);
            $this->vehicleLicense = $this->vehicleData['kenteken'];

            $this->saveVehicle();

            return redirect()->route('car.show', ['vehicle' => $this->vehicleLicense]);
        } else {
            $this->message = "Kenteken niet gevonden.";
            $this->vehicleData = [];
        }
    }


    protected function saveVehicle()
    {
        return Kenteken::updateOrCreate(
            ['licenseplate' => $this->vehicleLicense],
            [
                'formatted_licenseplate' => strtoupper($this->licensePlate),
                'data' => $this->vehicleData,
            ]
        );
    }


    public function render()
    {
        return view('livewire.car.add_car');
    }
}
