<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'អ៊ុតសក់ម៉ូត រួញ ឬក្ដោបចុង',
                'created_at' => '2025-08-14 19:51:06',
                'updated_at' => '2025-08-14 19:51:06',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'កាត់សក់តាមទម្រង់មុខ',
                'created_at' => '2025-08-14 19:51:11',
                'updated_at' => '2025-08-14 19:51:11',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'តរោមភ្នែក',
                'created_at' => '2025-08-14 19:51:16',
                'updated_at' => '2025-08-14 19:51:16',
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'name' => 'លាបសក់',
                'created_at' => '2025-08-14 19:51:24',
                'updated_at' => '2025-08-14 19:51:24',
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'name' => 'អ៊ុតត្រង់ធម្មជាតិ ឬអ៊ុតព្យាបាលNano , អ៊ុតBotox',
                'created_at' => '2025-08-14 19:51:30',
                'updated_at' => '2025-08-14 19:51:30',
            ],
            [
                'id' => 6,
                'user_id' => 1,
                'name' => 'កក់សក់ ឬស្ប៉ាសក់',
                'created_at' => '2025-08-14 22:04:07',
                'updated_at' => '2025-08-14 22:04:07',
            ],
            [
                'id' => 7,
                'user_id' => 1,
                'name' => 'ចិញ្ចេីម Fly stroke ,បបូរមាត់ Eyeliner',
                'created_at' => '2025-08-14 22:04:15',
                'updated_at' => '2025-08-14 22:04:15',
            ],
            [
                'id' => 8,
                'user_id' => 1,
                'name' => 'ឡាស៊ែរបណ្ដុះសក់',
                'created_at' => '2025-08-14 22:04:20',
                'updated_at' => '2025-08-14 22:04:20',
            ],
            [
                'id' => 9,
                'user_id' => 1,
                'name' => 'អ៊ុតរោមភ្នែក',
                'created_at' => '2025-08-14 22:04:40',
                'updated_at' => '2025-08-14 22:04:40',
            ],
            [
                'id' => 10,
                'user_id' => 1,
                'name' => 'អ៊ុតរោមចិញ្ចេីម',
                'created_at' => '2025-08-14 22:04:48',
                'updated_at' => '2025-08-14 22:04:48',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['id' => $service['id']], // Match by ID
                $service // Data to insert or update
            );
        }
    }
}
