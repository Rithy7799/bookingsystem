<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'មេផល ផ្សារថ្មី',
                'location' => 'https://maps.app.goo.gl/kxZi2iYDZpYH13t96?g_st=ic',
                'manager' => '012 6000 47 / 081 46 10 61',
                'phone' => '081461061',
                'status' => 'active',
                'created_at' => '2025-08-14 19:54:50',
                'updated_at' => '2025-08-14 22:05:54',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'មេផលសន្ធរមុខ',
                'location' => 'https://goo.gl/maps/Yvka42FdEd2uqLyM8',
                'manager' => '087 25 33 45 / 017 25 33 45',
                'phone' => '017253345',
                'status' => 'active',
                'created_at' => '2025-08-14 22:06:29',
                'updated_at' => '2025-08-14 22:06:29',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'មេផលវត្តទួល',
                'location' => 'https://goo.gl/maps/M4zz7EbkckwXCYF78',
                'manager' => '085 634 747/ 086 654 747',
                'phone' => '086654747',
                'status' => 'active',
                'created_at' => '2025-08-14 22:07:07',
                'updated_at' => '2025-08-14 22:07:07',
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'name' => 'មេផលទួលគោក',
                'location' => 'https://goo.gl/maps/X1gN5tRurCiswgwU9',
                'manager' => '061 394 747 / 081 584 747',
                'phone' => '081584747',
                'status' => 'active',
                'created_at' => '2025-08-14 22:07:36',
                'updated_at' => '2025-08-16 11:06:38',
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'name' => 'មេផលសៀមរាប',
                'location' => 'https://goo.gl/maps/r3UuWBmFsXuNs3o46',
                'manager' => '095944747/070644747',
                'phone' => '070644747',
                'status' => 'active',
                'created_at' => '2025-08-14 22:08:26',
                'updated_at' => '2025-08-14 22:08:26',
            ],
            [
                'id' => 6,
                'user_id' => 1,
                'name' => 'មេផលបឹងកេងកង',
                'location' => 'https://maps.app.goo.gl/iL2K6P1AoGNjCg126?g_st=ic',
                'manager' => '089904747/010704747',
                'phone' => '010704747',
                'status' => 'active',
                'created_at' => '2025-08-14 22:08:55',
                'updated_at' => '2025-08-14 22:08:55',
            ],
        ];

        foreach ($branches as $branch) {
            Branch::updateOrCreate(
                ['id' => $branch['id']], // Match by ID
                $branch // Data to insert or update
            );
        }
    }
}
