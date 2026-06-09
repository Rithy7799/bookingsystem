<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear permission cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $staff = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);

        // Define all permissions
        $permissions = [
            'users.create','users.delete', 'users.view',
            'branches.add', 'branches.update', 'branches.delete', 'branches.view',
            'services.add', 'services.update', 'services.delete', 'services.view',
            // 'bookings.add',
            'bookings.update', 'bookings.delete', 'bookings.view',
            'customers.add', 'customers.update', 'customers.delete', 'customers.view',
            'dashboard.view',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Assign all permissions to admin
        $admin->syncPermissions($permissions);

        // Assign selected permissions to staff
        $staff->syncPermissions([
            'users.view',
            'branches.add', 'branches.update', 'branches.view',
            'services.add', 'services.update', 'services.view',
            // 'bookings.add',
            'bookings.update', 'bookings.view',
            'customers.add', 'customers.update', 'customers.delete', 'customers.view',
            'dashboard.view',
        ]);

        // after create role permission create a user and assign permission direct.
// 1. Create User
        $super = User::create([
            'name' => 'super',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'image' => 'sadmin.jpg', // Make sure 'image' is a column in users table
        ]);

        // 2. Assign Role
        $super->assignRole('admin');
    }
}
