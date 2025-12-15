<?php

namespace App\Livewire\Checkout;

use App\Models\Address;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Billing extends Component
{
    private const SESSION_KEY = 'billing';

    private const DEFAULT_COUNTRY = 'NL';
    private const NEXT_ROUTE = 'checkout.shipping';

    public string $first_name = '';
    public string $last_name = '';
    public string $company_name = '';
    public string $phone_number = '';
    public string $street_address = '';
    public string $apartment = '';
    public string $city = '';
    public string $state = '';
    public string $postal_code = '';
    public string $email = '';
    public string $country = self::DEFAULT_COUNTRY;

    /**
     * Initializes properties based on the authenticated user's information.
     *
     * Retrieves the current authenticated user and populates various properties such as
     * first name, last name, email, phone number, company name, and address-related fields
     * if the authenticated user exists and has the respective data available. If the user's
     * full name is provided instead of separate first and last names, these are split
     * into first and last names.
     */
    public function mount()
    {
        $user = Auth::user();

        if ($user) {
            if (!empty($user->first_name) || !empty($user->last_name)) {
                $this->first_name = $user->first_name ?? '';
                $this->last_name = $user->last_name ?? '';
            } else {
                // Split full name
                $parts = explode(' ', $user->name, 2); // split op eerste spatie
                $this->first_name = $parts[0] ?? '';
                $this->last_name = $parts[1] ?? '';
            }

            $this->email = $user->email ?? '';
            $this->phone_number = $user->phone_number ?? '';
            $this->company_name = $user->company_name ?? '';

            if ($user->address) {
                $this->country = $user->address->country ?? 'NL';
                $this->street_address = trim($user->address->street . ' ' . $user->address->house_nr);
                $this->apartment = $user->address->apartment ?? '';
                $this->city = $user->address->city ?? '';
                $this->state = $user->address->state ?? '';
                $this->postal_code = $user->address->zipcode ?? '';
            }
        }
    }


    /**
     * Saves billing information for the authenticated user.
     *
     * Validates the billing data provided by the user against predefined rules and processes
     * it for database storage. The method splits the street address into its individual
     * components (street name and house number), prepares the data in the format required
     * by the database columns, and updates or creates the relevant records in the `address`
     * and `user` tables. If the validation or saving process encounters an issue, the error
     * is logged, and the user is redirected back with an error message and the original input.
     *
     * @return Redirector|RedirectResponse
     * @throws ValidationException
     */
    public function saveBilling(): Redirector|RedirectResponse
    {
        $validated = Validator::make($this->getValidationData(), $this->billingRules())->validate();

        try {
            $userId = auth()->id();

            // Split street address into street + house number (last token)
            $addressParts = preg_split('/\s+/', trim($validated['street_address'])) ?: [];
            if (count($addressParts) < 2) {
                session()->flash('error', 'Enter a valid street address.');
                return redirect()->back();
            }

            $houseNumber = array_pop($addressParts);
            $street = implode(' ', $addressParts);

            $addressAttributes = [
                'street' => $street,
                'house_nr' => $houseNumber,
                'zipcode' => $validated['postal_code'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'country' => $validated['country'],
            ];

            Address::updateOrCreate(['user_id' => $userId], $addressAttributes);

            $user = auth()->user();
            if ($user) {
                $fullName = trim($validated['first_name'] . ' ' . $validated['last_name']);

                $userAttributes = [
                    'name' => $fullName,
                    'email' => $validated['email'],
                    'phone_number' => $validated['phone_number'],
                ];

                $user->fill($userAttributes);

                if ($user->isDirty()) {
                    $user->save();
                }
            }

            session([self::SESSION_KEY => $validated]);

            return redirect()->route(self::NEXT_ROUTE);
        } catch (\Exception $e) {
            \Log::error('Error saving billing address: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'validated_fields' => $validated ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            session()->flash('error', 'Something went wrong while saving billing address. Try again.');
            return redirect()->back()->withInput();
        }
    }


    /**
     * Defines the validation rules for billing-related fields.
     *
     * Specifies an array of rules for validating billing information, including
     * fields such as first name, last name, email, phone number, company name,
     * and address details. Each field has constraints on requirements, data
     * types, and maximum lengths, ensuring the billing data is valid and complete.
     *
     * @return array An array of validation rules for billing data.
     */
    protected function billingRules(): array
    {
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

    /**
     * Prepares and returns an array of validation data.
     *
     * Constructs an associative array mapping field names to their corresponding
     * values from the current object properties. This array includes personal and
     * address-related data such as first name, last name, email, phone number,
     * company name, and detailed address components for validation purposes.
     *
     * @return array An array containing the validation data.
     */
    protected function getValidationData(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'company_name' => $this->company_name,
            'country' => $this->country,
            'street_address' => $this->street_address,
            'apartment' => $this->apartment,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
        ];
    }

    public function render(): View
    {
        return view('livewire.checkout.billing');
    }
}
