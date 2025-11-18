<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Artisan::call('passport:client --personal --no-interaction');
        
        User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin'
        ]);
        User::create([
            'username' => 'shop',
            'email' => 'shop@example.com',
            'password' => 'shop'
        ]);
        User::create([
            'username' => 'customer',
            'email' => 'customer@example.com',
            'password' => 'customer'
        ]);

        $permissions = [
        'index-user',
        'create-user',
        'view-user',
        'update-user',
        'delete-user',
        'index-item',
        'create-item',
        'view-item',
        'update-item',
        'delete-item',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'api']);
        }

        $admin = Role::create(['name' => 'admin',"guard_name" => 'api']);
        $admin->givePermissionTo(Permission::all());

        $shop = Role::create(['name' => 'shop', "guard_name" => 'api']);
        $shop->givePermissionTo(Permission::all()->filter(function ($permission) {
            return in_array($permission->name, ['index-item', 'create-item', 'view-item', 'update-item', 'delete-item']);
        }));

        $customer = Role::create(['name' => 'customer', "guard_name" => 'api']);
        $customer->givePermissionTo(Permission::all()->filter(function ($permission) {
            return in_array($permission->name, ['index-item', 'view-item']);
        }));

        $adminUser = User::where('username', 'admin')->first();
        $adminUser->assignRole($admin);

        $shopUser = User::where('username', 'shop')->first();
        $shopUser->assignRole($shop);

        $customerUser = User::where('username', 'customer')->first();
        $customerUser->assignRole($customer);
        
    }
}