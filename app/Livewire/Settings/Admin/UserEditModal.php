<?php

/**
 * This Livewire component handles the logic for editing user information
 * within the admin settings section of the CarMods application.
 *
 * Responsibilities:
 * - Allows authorized admin users to edit and update user details, roles, and addresses.
 * - Supports the ability to upload and safely save user avatar files.
 * - Ensures the user email uniqueness and validates the input fields according to specified rules.
 * - Restricts actions on users with certain roles (e.g., super-admin).
 * - Provides functionality to open and close the edit modal.
 * Dependencies:
 * - Utilizes multiple models including User and Address for database interactions.
 * - Interacts with Spatie Roles to manage role assignments and validations.
 * - Employs Livewire functionality such as lifecycle hooks and event handling.
 * - Supports file uploads and associated validation.
 * Properties:
 * - $userId: ID of the user being edited.
 * - $isOpen: Determines if the modal is open or closed.
 * - $avatarFile: Holds the avatar file being uploaded.
 * - User-specific fields: name, email, birthdate, bank_account, and role.
 * - Address fields: street, house_nr, zipcode, city, state, and country.
 * - $availableRoles: List of roles available for assignment.
 * Methods:
 * - mount(): Initializes the component, particularly loading available roles.
 * - open(int $rowId): Opens the modal for editing the specified user.
 * - close(): Closes the modal.
 * - save(): Validates and persists user and address data.
 * - rules(User $user): Generates the validation rules for user input.
 * - loadUser(int $userId): Loads and binds the user's details and address for editing.
 * - authorizeAdmin(): Ensures the action is only performed by an admin.
 * - render(): Returns the corresponding view for the component.
 * Events:
 * - Triggers specific events to refresh related UI components and notify about updates.
 * Note:
 * - Heavily relies on relationship-based eloquent queries for data retrieval and persistence.
 * - Includes protections to prevent unauthorized access or updates to super-admin users.
 */

namespace App\Livewire\Settings\Admin;

use /**
 * Address Model for the CarMods application.
 *
 * Represents the address entity within the CarMods application.
 * This model is responsible for interacting with the addresses
 * table in the MySQL database.
 *
 * The table is used to store information related to addresses
 * such as street, city, state, postal code, and any other
 * related details.
 *
 * Queue jobs may utilize this model in database queue
 * connections for background processing tasks.
 *
 * This model interacts with the database using Laravel's
 * Eloquent ORM for CRUD operations.
 */
    App\Models\Address;
use /**
 * Represents the User model in the CarMods application.
 *
 * This model interacts with the 'users' table in the MySQL database.
 * It is used for managing user-related data and relationships.
 *
 * Key notes:
 * - Part of the CarMods Laravel application.
 * - Uses the database queue connection for queued operations.
 *
 * Class Responsibilities:
 * - Handle authentication and user-related functionalities.
 * - Define relationships with other models.
 * - Interact with user-specific database operations.
 *
 * Configurations:
 * - The model assumes standard Laravel Eloquent conventions unless explicitly configured otherwise.
 *
 * Relationships:
 * - May include relationships with models like roles, permissions, vehicles, and orders.
 */
    App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use /**
 * Facade for accessing the authentication services provided by Laravel.
 *
 * The Illuminate\Support\Facades\Auth facade provides static-like access to
 * authentication-related functionality within the application, such as logging
 * in, logging out, checking if a user is authenticated, and retrieving the
 * currently authenticated user.
 *
 * This facade interacts with the application's authentication system, which
 * is configurable and supports drivers like sessions, tokens, or custom
 * implementations.
 *
 * Common usage includes user authentication, role and permission checks, and
 * user session management.
 *
 * Note: This facade requires proper configuration of the authentication
 * guards and providers, which can be managed in the `config/auth.php` file.
 *
 * @see https://laravel.com/docs/authentication
 */
    Illuminate\Support\Facades\Auth;
use /**
 * The Illuminate\Support\Str class provides a variety of string manipulation methods.
 * It includes utilities for modifying, parsing, and interrogating strings. These
 * utilities are commonly registered as macros and can be used throughout the
 * application for consistent string handling.
 *
 * This class is a core component of Laravel's helper functions, allowing developers
 * to perform actions such as string conversions, encoding checks, and substring
 * manipulations with ease.
 *
 * Note:
 * - The methods in this class are static and do not require instantiation.
 * - Heavily utilized in various Laravel features like facades, collections, and more.
 *
 * Dependencies:
 * - Requires the mbstring PHP extension for multibyte-capable string handling.
 *
 * Common Use Cases:
 * - Generating slugs or random strings.
 * - Manipulating casing, trimming, or replacing parts of strings.
 * - Checking if a string starts, ends, or contains a specified value.
 * - Encoding and decoding operations.
 */
    Illuminate\Support\Str;
use /**
 * The Rule class provides a set of validation rule methods
 * that are used to construct and customize validation rules
 * for attributes in your Laravel application.
 *
 * This class is part of the Illuminate\Validation namespace
 * and is essential for defining complex or conditional validation logic.
 *
 * Common use-cases for the Rule class include:
 * - Defining rules for specific database interactions.
 * - Constructing custom validation rules.
 * - Dynamically modifying validation rules based on the context.
 *
 * In the context of the CarMods application, this class can be
 * leveraged to perform advanced validation for user inputs,
 * especially if the data is tightly bound to database constraints.
 *
 * Utilizes database connection defined by the application using MySQL.
 */
    Illuminate\Validation\Rule;
use /**
 * Class On
 *
 * This class is an attribute provided by Livewire that allows you to
 * specify event listeners directly on a Livewire component or its methods.
 * It enables defining event bindings in an expressive and declarative way.
 *
 * Usage of this attribute enhances readability and eliminates the need
 * to manually register events in your components.
 *
 * When applied, the On attribute listens for the specified event and
 * executes the corresponding method on the component.
 *
 * Note:
 * - Ensure the event names specified align with the ones emitted in the application.
 * - This class is part of the Livewire framework.
 *
 * @package Livewire\Attributes
 */
    Livewire\Attributes\On;
use /**
 * Livewire Component for the CarMods Laravel Application.
 *
 * This component serves as a building block for creating dynamic, reactive interfaces
 * in the CarMods application. Livewire facilitates the inclusion of server-side logic
 * directly within the frontend for seamless interaction with backend data.
 *
 * Key Notes:
 * - Relies on Laravel framework version 12.42.0.
 * - Uses MySQL as its primary database.
 * - Configured to use 'database' as the queue connection.
 *
 * Responsibilities:
 * - Handle dynamic UI updates without requiring full page reloads.
 * - Facilitate interaction with the application's database layer.
 * - Ensure compliance with the CarMods application structure and logic.
 *
 * Dependencies:
 * - Laravel Livewire library.
 * - Database connection and queue configuration must be properly set in the Laravel application.
 */
    Livewire\Component;
use /**
 * Trait Livewire\WithFileUploads
 *
 * This trait provides functionalities for handling file uploads
 * in a Livewire component within the Laravel application.
 *
 * Features:
 * - Manages temporary file uploads.
 * - Ensures proper validation and secure file handling.
 * - Allows files to be easily stored and processed in the application.
 *
 * Requirements:
 * - The application must be configured to handle file uploads.
 * - Temporary files should be cleared periodically to manage storage usage.
 *
 * Notes:
 * - This trait is particularly useful for implementing user interfaces where file uploads
 *   are required without a full-page reload.
 * - Ensure that filesystem configurations are set correctly for file storage.
 */
    Livewire\WithFileUploads;
use /**
 * Represents a role within the application, provided by the Spatie Permission package.
 *
 * This model is used to define and manage user roles and their associated permissions
 * within the application.
 *
 * The roles are stored in the `roles` table in the MySQL database.
 *
 * Relationships:
 * - This model has a many-to-many relationship with the Permission model.
 * - This model can also have a many-to-many relationship with the User model.
 *
 * Features:
 * - Supports assigning permissions to roles.
 * - Provides methods to check, sync, and revoke permissions assigned to roles.
 *
 * Configuration:
 * - Role permissions are managed based on the package's built-in functionality.
 * - Ensure the required migrations for roles and permissions are executed.
 *
 * Usage Context:
 * - Used by the authorization layer to control and enforce user access levels based on roles.
 * - Can be utilized with built-in middleware to restrict routes according to assigned roles.
 *
 * Requirements:
 * - Spatie Permission package must be installed and configured.
 * - This model relies on the `database` queue connection setup.
 *
 * @see https://spatie.be/docs/laravel-permission
 */
    Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class UserEditModal
 *
 * Handles the functionality for managing and editing user records in the application.
 * Includes file upload capabilities, form validation, and data synchronization.
 */
class UserEditModal extends Component
{
    use WithFileUploads;

    public ?int $userId = null;

    public bool $isOpen = false;

    public $avatarFile;

    public string $name = '';
    public string $email = '';
    public string $birthdate = '';
    public string $bank_account = '';
    public string $role = '';

    public string $street = '';
    public string $house_nr = '';
    public string $zipcode = '';
    public string $city = '';
    public string $state = '';
    public string $country = '';

    /** @var array<int, array{id:int,name:string}> */
    public array $availableRoles = [];

    /**
     * Initialize the component by fetching and setting the available roles.
     */
    public function mount(): void
    {
        // pak alle rollen per id en naam
        $this->availableRoles = Role::query()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (Role $role) => ['id' => $role->id, 'name' => $role->name])
            ->all();
    }

    /**
     * Handle the "edit" event by authorizing the admin, loading the specified user,
     * resetting any validation errors, and opening the editing interface.
     *
     * @param int $rowId The identifier of the user to be edited.
     */
    #[On('edit')]
    public function open(int $rowId): void
    {
        $this->authorizeAdmin();

        $this->loadUser($rowId);
        $this->resetValidation();

        $this->isOpen = true;
    }

    /**
     * Closes the current instance by setting its state to not open.
     */
    public function close(): void
    {
        $this->isOpen = false;
    }

    /**
     * Saves user details including their address, avatar, and roles.
     *
     * The method first ensures the user has administrative privileges and
     * validates the provided data. The user's address and profile information
     * are then updated or created. If a new avatar file is provided, it is saved
     * and associated with the user. Additionally, any changes to the user's role
     * or email address are applied, and relevant events are dispatched.
     *
     */
    public function save(): void
    {
        // kijk of gebruiker admin is
        $this->authorizeAdmin();

        // pak adress en rollen
        $user = User::query()->with(['address', 'roles'])->findOrFail($this->userId);

        // valideer
        $this->validate($this->rules($user));

        $address = $user->address ?? new Address();

        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
            'birthdate' => $this->birthdate ?: null,
            'bank_account' => $this->bank_account ?: null,
        ]);

        $address->fill([
            'street' => $this->street,
            'house_nr' => $this->house_nr,
            'zipcode' => $this->zipcode,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
        ]);

        // sla adres op in db
        $address->save();
        $user->address()->associate($address);

        // sla avatar goed op
        if ($this->avatarFile) {
            $userId = $user->id;
            $randomString = Str::random(8);
            $extension = '.' . $this->avatarFile->getClientOriginalExtension();
            $filename = 'avatar' . $randomString . $extension;

            saveFileSafely($this->avatarFile, $this->userId, 'avatars');
            $user->avatar = $filename;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($this->role !== '') {
            $user->syncRoles([$this->role]);
        }

        // dispatch event voor updaten tabel en user update
        $this->dispatch('pg:eventRefresh-user-table-nkoz16-table');
        $this->dispatch('admin-user-updated');

        $this->close();
    }

    /**
     * Defines validation rules for the given user instance.
     *
     * The rules include requirements for fields such as name, email, avatar file,
     * birthdate, bank account, role, and address-related attributes.
     * Specific constraints are applied for format, maximum length, uniqueness,
     * and existence in related database tables as needed.
     *
     * @param User $user The user instance to be validated.
     * @return array An array containing validation rules.
     */
    protected function rules(User $user): array
    {
        // validatie regels
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'avatarFile' => ['nullable', 'image', 'max:2048'],
            'birthdate' => ['nullable', 'date'],
            'bank_account' => ['nullable', 'string', 'max:50'],
            'role' => ['required', 'string', 'exists:roles,name'],
            'street' => ['nullable', 'string', 'max:255'],
            'house_nr' => ['nullable', 'string', 'max:50'],
            'zipcode' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Loads user data from the database and sets relevant properties for the instance.
     *
     * @param int $userId The unique identifier of the user to load.
     *
     * @throws ModelNotFoundException If no user is found for the given ID.
     * @throws HttpException If the user has the 'super-admin' role.
     */
    protected function loadUser(int $userId): void
    {
        // laad gebruiker
        $user = User::query()->with(['address', 'roles'])->findOrFail($userId);

        if ($user->hasRole('super-admin')) {
            abort(403);
        }

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->birthdate = (string) ($user->birthdate ?? '');
        $this->bank_account = (string) ($user->bank_account ?? '');
        $this->role = (string) ($user->roles->first()?->name ?? '');

        $this->street = (string) ($user->address?->street ?? '');
        $this->house_nr = (string) ($user->address?->house_nr ?? '');
        $this->zipcode = (string) ($user->address?->zipcode ?? '');
        $this->city = (string) ($user->address?->city ?? '');
        $this->state = (string) ($user->address?->state ?? '');
        $this->country = (string) ($user->address?->country ?? '');
    }

    /**
     * Authorizes the currently authenticated user and verifies if they have the 'admin' role.
     * If the user is not authenticated or lacks the 'admin' role, it aborts with a 403 response.
     */
    protected function authorizeAdmin(): void
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('admin')) {
            abort(403);
        }
    }

    /**
     *
     */
    public function render()
    {
        return view('livewire.settings.admin.user-edit-modal');
    }
}
