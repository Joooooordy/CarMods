<?php

namespace App\Livewire\Checkout;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Livewire\Component;

class Shipping extends Component
{
    public string $first_name, $last_name, $company_name, $street_address, $apartment, $city, $state, $postal_code, $country = 'NL';
    public mixed $phone_number;
    public bool $different_address = false;

    public function mount(): Redirector|RedirectResponse
    {
        if (!$this->different_address) {
            $this->loadSessionData();
        }

        return redirect()->route('checkout.payment');
    }

    public function updatedDifferentAddress($value): void
    {
        $value ? $this->resetShippingData() : $this->loadSessionData();
    }

    protected function loadSessionData(): void
    {
        $billing = Session::get('billing', []);
        foreach (['first_name', 'last_name', 'company_name', 'country', 'street_address', 'apartment', 'city', 'state', 'postal_code'] as $field) {
            $this->$field = $billing[$field] ?? ($field === 'country' ? 'US' : '');
        }
    }

    protected function resetShippingData(): void
    {
        foreach (['first_name', 'last_name', 'company_name', 'street_address', 'apartment', 'city', 'state', 'postal_code'] as $field) {
            $this->$field = '';
        }
        $this->country = 'US';
    }

    public function saveShipping(): RedirectResponse
    {
        $validated_fields = $this->validate([
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
        ]);

        session(['shipping' => $validated_fields]);

        return redirect()->route('checkout.payment');
    }

    public function render(): View
    {
        return view('livewire.checkout.shipping');
    }
}
