<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingandContacts extends Model
{
     protected $table = 'bookingcontacts';
      protected $fillable = [
        'booking',
        'contact',
        'note',
    ];
}
