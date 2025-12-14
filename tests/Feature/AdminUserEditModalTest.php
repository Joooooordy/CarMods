<?php

use App\Livewire\Settings\Admin\UserEditModal;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::findOrCreate('admin');
    Role::findOrCreate('user');
});

test('non-admin cannot access admin user panel route', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $this->actingAs($user)
        ->get(route('settings.admin_user_panel'))
        ->assertForbidden();
});

test('admin can open modal and update a user', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $target = User::factory()->create([
        'name' => 'Old Name',
        'email' => 'old@example.com',
    ]);
    $target->assignRole('user');

    Livewire::actingAs($admin)
        ->test(UserEditModal::class)
        ->call('open', $target->id)
        ->assertSet('userId', $target->id)
        ->set('name', 'New Name')
        ->set('email', 'new@example.com')
        ->set('role', 'user')
        ->call('save');

    $target->refresh();

    expect($target->name)->toBe('New Name');
    expect($target->email)->toBe('new@example.com');
    expect($target->hasRole('user'))->toBeTrue();
});
