<?php

namespace App\Http\Livewire\Checkout;

use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Billing extends Component
{
    public $first_name, $last_name, $company_name, $country = 'US';
    public $street_address, $apartment, $city, $state, $postal_code;

    public function saveBilling()
    {
        $validated_fields = Validator::make($this->getValidationData(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|int|max:20',
            'company_name' => 'nullable|string|max:255',
            'country' => 'required|string|max:100',
            'street_address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ])->validate();

        session(['billing' => $validated_fields]);

        return redirect()->route('checkout.shipping');
    }

    protected function getValidationData()
    {
        return get_object_vars($this);
    }

    public function render()
    {
        return view('livewire.checkout.billing');
    }
}
