<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'branch_id',
    'service_id',
    'booking_id',
    'payment',
    'total',
    'note',
];


     public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }
    public function booking(){
        return $this->belongsTo(Booking::class,'booking_id');
    }
}
