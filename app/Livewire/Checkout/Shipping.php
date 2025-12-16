<?php

namespace App\Livewire\Checkout;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

class Shipping extends Component
{
    private const DEFAULT_COUNTRY = 'NL';

    private const SESSION_KEY = 'shipping';
    private const NEXT_ROUTE = 'checkout.payment';

    private const FORM_FIELDS = [
        'first_name',
        'last_name',
        'company_name',
        'email',
        'phone_number',
        'country',
        'street_address',
        'apartment',
        'city',
        'state',
        'postal_code',
    ];

    private const RESETTABLE_FIELDS = [
        'first_name',
        'last_name',
        'company_name',
        'email',
        'phone_number',
        'street_address',
        'apartment',
        'city',
        'state',
        'postal_code',
    ];

    public string $first_name;
    public string $last_name;
    public string $company_name;
    public string $email;
    public string $phone_number;
    public string $street_address;
    public string $apartment;
    public string $city;
    public string $state;
    public string $postal_code;
    public string $country = self::DEFAULT_COUNTRY;

    public bool $different_address = false;

    public function mount(): void
    {
        if (!$this->different_address) {
            $this->loadSessionData();
        }
    }

    public function continue(): Redirector|RedirectResponse
    {
        if (!$this->different_address) {
            session(['shipping' => session('billing')]);

            return redirect()->route('checkout.payment');
        }

        return $this->saveShipping();
    }

    public function updatedDifferentAddress(bool $value): void
    {
        $value ? $this->resetShippingData() : $this->loadSessionData();
    }

    protected function loadSessionData(): void
    {
        $billing = Session::get('billing', []);

        foreach (self::FORM_FIELDS as $field) {
            $this->$field = $billing[$field] ?? ($field === 'country' ? self::DEFAULT_COUNTRY : '');
        }
    }

    protected function resetShippingData(): void
    {
        foreach (self::RESETTABLE_FIELDS as $field) {
            $this->$field = '';
        }

        $this->country = self::DEFAULT_COUNTRY;
    }

    public function saveShipping(): RedirectResponse
    {
        // validatie
        $validated = Validator::make($this->getValidationData(), $this->billingRules())
            ->validate();

        try {
            $userId = auth()->id();

            // Split street_address in 2 velden: straat en huisnummer
            $addressParts = preg_split('/\s+/', trim($validated['street_address'])) ?: [];
            if (count($addressParts) < 2) {
                session()->flash('error', 'Enter a valid street address.');
                return redirect()->back();
            }

            $houseNumber = array_pop($addressParts);
            $street = implode(' ', $addressParts);

            // zet attributen voor opslaan in db
            $addressAttributes = [
                'street' => $street,
                'house_nr' => $houseNumber,
                'zipcode' => $validated['postal_code'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'country' => $validated['country'],
            ];

            // sla adres op in db
            Address::updateOrCreate(['user_id' => $userId], $addressAttributes);

            // kijk of user bewerkt is tijdens het invullen van formulier
            // ja: zet first_name en last_name bij elkaar voor db opslaan
            // en zet de attributen, daarna opslaan in db
            $user = auth()->user();
            if ($user) {
                $fullName = trim($validated['first_name'] . ' ' . $validated['last_name']);

                $user->fill([
                    'name' => $fullName,
                    'email' => $validated['email'],
                    'phone_number' => $validated['phone_number'],
                ]);

                if ($user->isDirty()) {
                    $user->save();
                }
            }

            session([self::SESSION_KEY => $validated]);

            return redirect()->route(self::NEXT_ROUTE);
        } catch (\Exception $e) {
            \Log::error('Error saving shipping address: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'validated_fields' => $validated ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'Something went wrong while saving shipping address. Try again.');
            return redirect()->back()->withInput();
        }
    }

    protected function rules(): array
    {
        // validatie regels
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'country' => 'required|string|max:100',
            'street_address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ];
    }

    protected function getFormFields(): array
    {
        $data = [];

        foreach (self::FORM_FIELDS as $field) {
            $data[$field] = $this->$field;
        }

        return $data;
    }

    public function render(): View
    {
        return view('livewire.checkout.shipping');
    }
}
