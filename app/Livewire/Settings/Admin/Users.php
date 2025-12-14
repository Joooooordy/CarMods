<?php

namespace App\Livewire\Settings\Admin;

use App\Livewire\UserTable;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\UploadedFile;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 15;
    public int $userId;
    public bool $isEditing = false;
    public bool $showForm = false;
    public string $name, $email, $password, $birthdate, $address, $bank_account;
    public mixed $avatar;
    protected string $paginationTheme = 'tailwind';

    protected array $queryString = ['search'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function toggleForm(): void
    {
        $this->showForm = !$this->showForm;
        $this->resetForm();
    }

    public function delete(int $userId): void
    {
        User::findOrFail($userId)->delete();
        $this->resetForm();
    }

    public function editUser(int $userId)
    {
        $user = User::findOrFail($userId);
        $this->userId = $userId;
        $this->name = $user->name;
        $this->birthdate = $user->birthdate;
        $this->address = $user->address;
        $this->email = $user->email;
        $this->bank_account = $user->bank_account;
        $this->password = $user->password;
        $this->isEditing = true;
        $this->avatar = null;
        $this->showForm = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->avatar instanceof UploadedFile) {
            $data['avatar'] = saveFileSafely($this->avatar, 'user', $this->userId);
        } elseif ($this->isEditing) {
            unset($data['avatar']);
        }

        User::updateOrCreate(
            ['id' => $this->userId],
            $data
        );

        $this->resetForm();
        $this->showForm = false;
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'birthdate', 'address', 'email', 'bank_account', 'password', 'avatar', 'isEditing']);
    }

    public function render(): View
    {
        $users = User::with('roles', 'permissions') // eager load
        ->where(function ($query) {
            $query->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.settings.admin.users', compact('users'));
    }

}
