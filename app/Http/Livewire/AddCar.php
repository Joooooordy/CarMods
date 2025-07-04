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
                'formatted_licenseplate' => $this->formatLicensePlate($this->vehicleLicense),
                'data' => $this->vehicleData,
            ]
        );
    }

    protected function formatLicensePlate(string $kenteken): string
    {
        $kenteken = strtoupper(preg_replace('/[^A-Z0-9]/', '', $kenteken));

        // RDW heeft 9 officiële kentekenformaten
        $formats = [
            '/^([A-Z]{2})([0-9]{2})([0-9]{2})$/'     => '$1-$2-$3',  // AB-12-34
            '/^([0-9]{2})([0-9]{2})([A-Z]{2})$/'     => '$1-$2-$3',  // 12-34-AB
            '/^([0-9]{2})([A-Z]{2})([0-9]{2})$/'     => '$1-$2-$3',  // 12-AB-34
            '/^([A-Z]{2})([0-9]{2})([A-Z]{2})$/'     => '$1-$2-$3',  // AB-12-CD
            '/^([A-Z]{2})([A-Z]{2})([0-9]{2})$/'     => '$1-$2-$3',  // AB-CD-12
            '/^([0-9]{2})([A-Z]{2})([A-Z]{2})$/'     => '$1-$2-$3',  // 12-AB-CD
            '/^([0-9]{2})([A-Z]{3})([0-9]{1})$/'     => '$1-$2-$3',  // 12-ABC-3
            '/^([A-Z]{3})([0-9]{2})([A-Z]{1})$/'     => '$1-$2-$3',  // ABC-12-D
            '/^([A-Z]{3})([0-9]{2})([0-9]{1})$/'     => '$1-$2-$3',  // BFG-12-3
            '/^([A-Z]{1})([0-9]{3})([A-Z]{2})$/'     => '$1-$2-$3',  // A-123-BC
        ];

        foreach ($formats as $regex => $replacement) {
            if (preg_match($regex, $kenteken)) {
                return preg_replace($regex, $replacement, $kenteken);
            }
        }

        // fallback: niets veranderd
        return $kenteken;
    }

    public function render()
    {
        return view('livewire.car.add_car');
    }
}
