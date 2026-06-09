<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
   public function List(Request $request)
{
    $customers = Customer::paginate(10); // You only need to call this once
    $services = Service::all();
    $branches = Branch::all();

    // Get confirmed bookings
    $confirmedBookings = Booking::where('status', 'confirmed')->get();
 $query = Booking::where('status', 'confirmed')
        ->with(['service', 'branch'])
        ->orderBy('created_at', 'desc');

    if ($request->from_date) {
        $query->whereDate('booking_date', '>=', $request->from_date);
    }

    if ($request->to_date) {
        $query->whereDate('booking_date', '<=', $request->to_date);
    }
    return view('Backend.Customer.List', compact('customers', 'services', 'branches', 'confirmedBookings'));
}


    public function create(){
        return view('Backend.Customer.Create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'service_id' => 'required|exists:services,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'payment' => 'required|string',
            'total' => 'required|numeric',
            'note' => 'required|string',
        ]);

        $customer = new Customer();
        $customer->user_id = $request->user_id;
        $customer->branch_id = $request->branch_id;
        $customer->service_id = $request->service_id;
        $customer->booking_id = $request->booking_id;
        $customer->payment = $request->payment;
        $customer->total = $request->total;
        $customer->note = $request->note;
        $customer->save();
        return redirect()->route('list.customer ')->with('success', 'Customer add successfully');
    }
 
  public function View($id) {
    $services = Service::all();
    $branches = Branch::all();
    $bookings = Booking::all();
    $customer = Customer::findOrFail($id);  // fetch specific customer by ID

    return view('Backend.Customer.View', compact('services', 'branches','bookings' ,'customer'));
}

}
