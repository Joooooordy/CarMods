<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Permissies aanmaken
        Permission::firstOrCreate(['name' => 'view admin panel']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);

        // Rollen aanmaken
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        $adminRole->givePermissionTo(['view admin panel', 'edit users', 'delete users']);

        // 25 gebruikers met adressen
        $users = User::factory()->count(25)->create()->each(function ($user, $index) {
            $address = Address::factory()->create(['user_id' => $user->id]);

            $roleId = ($index % 5 === 0) ? 1 : 2;

            $user->update([
                'address_id' => $address->id,
                'role_id' => $roleId,
            ]);

            $user->assignRole($roleId === 1 ? 'admin' : 'user');

            // Orders en Payments per user
            $orders = Order::factory(rand(2,5))->create([
                'user_id' => $user->id,
            ]);

            $orders->each(function($order) use ($user) {
                Payment::factory()->create([
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                ]);
            });
        });

        // Specifieke test admin user
        $testUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'role_id' => 1,
        ]);
        $address = Address::factory()->create(['user_id' => $testUser->id]);
        $testUser->update(['address_id' => $address->id]);
        $testUser->assignRole('admin');

        // Producten
        Product::factory()->count(100)->create();
    }
}
