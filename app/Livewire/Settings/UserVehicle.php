<?php

namespace App\Livewire\Settings;

use App\Livewire\Car\CarData;
use App\Models\Kenteken;
use App\Models\Vehicle as VehicleModel;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\On;
use Livewire\Component;

class UserVehicle extends Component
{
    public array $formattedFields = [];
    public array $vehiclesWithFormattedFields = [];

    public function mount()
    {
        $user = auth()->user();

        $this->vehiclesWithFormattedFields = $user->vehicles->map(function($vehicle) {
            $formattedFields = [];

            foreach ($vehicle->kenteken->data ?? [] as $key => $value) {
                // skip velden die je niet wilt tonen
                if ((new CarData)->shouldSkipField($key)) {
                    continue;
                }

                $formattedFields[] = [
                    'label' => formatLabel($key),
                    'value' => formatFieldValue($key, $value),
                ];
            }

            return [
                'vehicle' => $vehicle,
                'formattedFields' => $formattedFields,
            ];
        })->toArray();
    }



    public function getVehicles(User $user)
    {
        $this->formattedFields = [];

        return $user->vehicles()->with('kenteken')->get();
    }


    public function render()
    {
        $vehicles = $this->getVehicles(auth()->user());

        return view('livewire.settings.user-vehicle', compact('vehicles'));
    }
}
