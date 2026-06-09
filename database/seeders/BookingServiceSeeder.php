<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookingServices = [
            ['booking_id' => 34, 'service_id' => 2],
            ['booking_id' => 27, 'service_id' => 4],
            ['booking_id' => 32, 'service_id' => 4],
            ['booking_id' => 33, 'service_id' => 2],
            ['booking_id' => 9, 'service_id' => 1],
            ['booking_id' => 10, 'service_id' => 2],
            ['booking_id' => 11, 'service_id' => 5],
            ['booking_id' => 12, 'service_id' => 3],
            ['booking_id' => 13, 'service_id' => 2],
            ['booking_id' => 14, 'service_id' => 1],
            ['booking_id' => 15, 'service_id' => 2],
            ['booking_id' => 28, 'service_id' => 2],
            ['booking_id' => 17, 'service_id' => 5],
            ['booking_id' => 18, 'service_id' => 2],
            ['booking_id' => 19, 'service_id' => 10],
            ['booking_id' => 20, 'service_id' => 5],
            ['booking_id' => 21, 'service_id' => 6],
            ['booking_id' => 22, 'service_id' => 9],
            ['booking_id' => 23, 'service_id' => 2],
            ['booking_id' => 29, 'service_id' => 5],
            ['booking_id' => 35, 'service_id' => 1],
            ['booking_id' => 36, 'service_id' => 5],
            ['booking_id' => 37, 'service_id' => 1],
            ['booking_id' => 38, 'service_id' => 2],
            ['booking_id' => 39, 'service_id' => 3],
            ['booking_id' => 40, 'service_id' => 6],
            ['booking_id' => 41, 'service_id' => 2],
            ['booking_id' => 42, 'service_id' => 2],
            ['booking_id' => 43, 'service_id' => 5],
            ['booking_id' => 52, 'service_id' => 5],
            ['booking_id' => 46, 'service_id' => 3],
            ['booking_id' => 48, 'service_id' => 2],
            ['booking_id' => 49, 'service_id' => 2],
            ['booking_id' => 50, 'service_id' => 1],
            ['booking_id' => 51, 'service_id' => 1],
            ['booking_id' => 53, 'service_id' => 2],
            ['booking_id' => 54, 'service_id' => 2],
            ['booking_id' => 55, 'service_id' => 2],
            ['booking_id' => 56, 'service_id' => 2],
        ];

        foreach ($bookingServices as $bookingService) {
            $booking = Booking::find($bookingService['booking_id']);
            if ($booking) {
                $booking->services()->syncWithoutDetaching([
                    $bookingService['service_id'] => ['created_at' => now(), 'updated_at' => now()]
                ]);
            }
        }
    }
}
