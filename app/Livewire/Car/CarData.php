<?php

namespace App\Livewire\Car;

use App\Livewire\Settings\UserVehicle;
use App\Models\Vehicle as VehicleModel;
use Livewire\Component;
use App\Models\Kenteken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CarData extends Component
{
    public mixed $vehicle = '';
    public string $licensePlate = '';
    public string $formattedLicensePlate = '';
    public array $vehicleData = [];
    public array $formattedFields = [];
    private const SKIP_PREFIXES = ['api_', 'registratie'];
    private const SKIP_SUFFIXES = ['_dt'];

    public const DATE_SUFFIXES = ['_dt', '_datum'];
    public const DATE_PREFIXES = ['datum_', 'vervaldatum_'];

    public const CURRENCY_KEYS = ['catalogusprijs', 'bpm'];
    public const WEIGHT_KEYS = ['massa', 'gewicht'];
    public const VOLUME_KEYS = ['inhoud'];
    public const SPEED_KEYS = ['snelheid'];
    public const POWER_KEYS = ['vermogen'];

    /**
     * Initializes and processes vehicle data for the component.
     *
     * @param mixed $vehicle The input vehicle identifier to process.
     * @return void
     */
    public function mount(mixed $vehicle): void
    {
        $this->vehicle = strtoupper(preg_replace('/[^A-Z0-9]/', '', $vehicle));

        $kenteken = Kenteken::where('licenseplate', $this->vehicle)->firstOrFail();

        $this->licensePlate = $kenteken->licenseplate;

        $this->formattedLicensePlate = $kenteken->formatted_licenseplate ?? $kenteken->licenseplate;
        $this->vehicleData = $kenteken->data ?? [];

        $this->formattedFields = [];

        foreach ($this->vehicleData as $key => $value) {
            if ($this->shouldSkipField($key)) {
                continue;
            }

            $this->formattedFields[] = [
                'label' => formatLabel($key),
                'value' => formatFieldValue($key, $value),
            ];
        }
    }

    /**
     * Determines if the specified field should be skipped based on predefined prefixes or suffixes.
     *
     * @param string $key The field name to evaluate.
     * @return bool True if the field matches the skip criteria; otherwise, false.
     */
    public function shouldSkipField(string $key): bool
    {
        return Str::startsWith($key, self::SKIP_PREFIXES)
            || Str::endsWith($key, self::SKIP_SUFFIXES);
    }

    /**
     * Handles the addition of a vehicle and associates it with the authenticated user.
     * Validates the input, ensures the user is logged in, and creates or fetches
     * the corresponding license plate and vehicle records.
     *
     * @return RedirectResponse|void Redirects to the login page if the user is not authenticated;
     * otherwise, processes the vehicle addition.
     */
    public function addVehicle()
    {

        $this->validate([
            'licensePlate' => 'required|string|min:6|max:8',
        ]);

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $kenteken = Kenteken::firstOrCreate(
            ['licenseplate' => strtoupper($this->licensePlate)]
        );

        $vehicle = VehicleModel::firstOrCreate([
            'user_id' => auth()->id(),
            'licenseplate_id' => $kenteken->id,
        ]);

        session()->flash('success', 'Vehicle saved successfully!');
    }

    /**
     * Renders the Livewire component view for car data.
     *
     * @return View The view instance to be rendered.
     */
    public function render(): View
    {
        return view('livewire.car.car-data');
    }
}
