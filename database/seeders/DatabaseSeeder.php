<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Maak permissies aan
        Permission::firstOrCreate(['name' => 'view admin panel']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);

        // Maak rollen aan
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Koppel permissies aan rollen
        $adminRole->givePermissionTo([
            'view admin panel',
            'edit users',
            'delete users',
        ]);

        // Maak 25 gebruikers aan met bijbehorende adressen
        $users = User::factory()->count(25)->create();

        foreach ($users as $index => $user) {
            // Adres aanmaken en koppelen
            $address = Address::factory()->create([
                'user_id' => $user->id,
            ]);
            $user->update(['address_id' => $address->id]);

            // Rol toewijzen
            if ($index % 5 === 0) {
                $user->assignRole('admin');
            } else {
                $user->assignRole('user');
            }
        }

        // Specifieke test admin user
        $testUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
        ]);
        $address = Address::factory()->create([
            'user_id' => $testUser->id,
        ]);
        $testUser->update(['address_id' => $address->id]);
        $testUser->assignRole('admin');

        Product::factory()->count(100)->create();
    }
}
