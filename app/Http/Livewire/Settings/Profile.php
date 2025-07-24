<?php

namespace App\Http\Livewire\Settings;

use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithDispatchesBrowserEvents;

class Profile extends Component
{
    use WithFileUploads;

    public $avatarFile;

    public string $name = '';
    public string $email = '';
    public string $birthdate = '';
    public string $bank_account = '';
    public string $address_id = '';

    public string $addresses;
    public string $street = '';
    public string $house_nr = '';
    public string $zipcode = '';
    public string $city = '';
    public string $state = '';
    public string $country = '';

    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->birthdate = $user->birthdate ?? '';
        $this->bank_account = $user->bank_account ?? '';
        $this->address_id = $user->address_id ?? '';
        $this->addresses = Address::all();

        if ($user->address) {
            $this->street = $user->address->street;
            $this->house_nr = $user->address->house_nr;
            $this->zipcode = $user->address->zipcode;
            $this->city = $user->address->city;
            $this->state = $user->address->state;
            $this->country = $user->address->country;
        }
    }

    public function updateProfileInformation(): void
    {
        $user = Auth::user();
        $address = Address::find($this->address_id) ?? new Address(['user_id' => $user->id]);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'avatarFile' => ['nullable', 'image', 'max:2048'],
            'birthdate' => ['nullable', 'date'],
            'bank_account' => ['nullable', 'string', 'max:50'],
            'address_id' => ['nullable', 'exists:addresses,id'],
        ]);

        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'bank_account' => $this->bank_account,
            'address_id' => $this->address_id,
        ]);

        $address->fill([
            'street' => $this->street,
            'house_nr' => $this->house_nr,
            'zipcode' => $this->zipcode,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ]);

        $address->save();

        if ($this->avatarFile) {
            $userId = $user->id;
            $random_string = Str::random(8);
            $extension = '.' . $this->avatarFile->getClientOriginalExtension();

            // Correct: voeg punt toe tussen random string en extensie
            $filename = 'avatar' . $random_string . $extension;

            // Sla bestand op in storage/app/public/avatars/{user_id}/filename
            $path = $this->avatarFile->storeAs("{$userId}/avatars", $filename, 'public');

            // Alleen bestandsnaam opslaan in DB
            $user->avatar = $filename;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('browser-event', [
            'name' => 'profile-updated',
            'data' => [
                'avatar' => avatar_url($user),
            ],
        ]);

        $this->dispatch('profile-updated', name: $user->name);
    }

    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(route('dashboard'));
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
}


