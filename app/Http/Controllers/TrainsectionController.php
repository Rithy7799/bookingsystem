<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Service;
use Illuminate\Http\Request;

class TrainsectionController extends Controller
{
    public function trainsection(){
       
         $branches = Branch::all();
         $services = Service::all();
         $bookings = Booking::all();
          $bookings = Booking::with(['branch', 'services']);
          $bookingsData = $bookings->get();
         $confirmedBookings = $bookingsData->where('status', 'confirmed');

        return view('Backend.Trainsection.List',compact('bookings','branches','services','confirmedBookings'));
    }
}
