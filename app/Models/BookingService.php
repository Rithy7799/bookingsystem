<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    protected $fillable = ['booking_id', 'service_id'];

    protected $table = 'booking_services'; // Explicitly define the table
    public $incrementing = false; // No auto-incrementing ID since it's a pivot
    protected $guarded = []; // Allow mass assignment of all fields

    // Optional: Define relationships if needed
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
