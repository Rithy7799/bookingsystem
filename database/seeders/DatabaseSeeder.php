<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Run role seeder first
        $this->call([
           RolePermissionSeeder::class,
           BranchSeeder::class,
           BookingSeeder::class,
           ServiceSeeder::class,
           BookingServiceSeeder::class,
        ]);

        
    }
}
