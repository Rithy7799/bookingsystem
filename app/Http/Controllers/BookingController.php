<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Branch;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;


class BookingController extends Controller
{
    //    public function __construct(){
    //     $this->middleware(['permission:bookings.view'])->only('List');
    //     $this->middleware(['permission:bookings.add'])->only('Store');
    //     $this->middleware(['permission:bookings.update'])->only('Update');
    //     $this->middleware(['permission:bookings.delete'])->only('Delete');

    //    }


    public function  store_test(Request $request)
    {
        dd($request->all());
    }
   public function FormRegister(){
         $services = Service::all();
         $branches  = Branch::all();
        return view('Frontend.Index',compact('services','branches'));
    }

    public function alert(){


        return view('Frontend.Alert');
    }

public function List(Request $request)
{
    $services = Service::all();
    $branches = Branch::all();

    $time = $request->input('time', 'this_week');

    if ($time === 'last_week') {
        $start = Carbon::now()->subWeek()->startOfWeek();
        $end   = Carbon::now()->subWeek()->endOfWeek();
    } else {
        $start = Carbon::now()->startOfWeek();
        $end   = Carbon::now()->endOfWeek();
    }

    // Base query for the selected time range
    $baseQuery = Booking::whereBetween('created_at', [$start, $end]);

    $totalBookings    = (clone $baseQuery)->count();
    $totalConfirmed   = (clone $baseQuery)->where('status', 'confirmed')->count();
    $totalProcessing  = (clone $baseQuery)->where('status', 'processing')->count();
    $totalCancel      = (clone $baseQuery)->where('status', 'cancel')->count();

    // List bookings only in this range
    $bookings = $baseQuery
        ->orderBy('created_at', 'desc')
        ->paginate(50)
        ->withQueryString();

    return view('Backend.Booking.List', compact(
        'bookings',
        'services',
        'branches',
        'time',
        'totalBookings',
        'totalConfirmed',
        'totalProcessing',
        'totalCancel'
    ));
}

    public function Create(){
                        $services = Service::all();
                        $branches  = Branch::all();
                        return view('Backend.Booking.Create',compact('services','branches'));
                    }

public function Store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'branch_id' => 'required|exists:branches,id',
        'service_id' => 'required|array|min:1', // Ensure at least one service is selected
        'service_id.*' => 'exists:services,id', // Validate each service ID
        'know_through' => 'nullable|in:1,2,3,4,5,6',
        'booking_date' => 'required|date|after_or_equal:today',
        'booking_time' => 'required|date_format:H:i',
        'payment' => 'nullable|numeric|min:0',
        'status' => 'required|in:confirmed,processing,cancel',
        'note' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', 
    ]);
//    dd($validated);

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('Booking'), $filename);
        $validated["image"] = $filename;
    }
    $booking = Booking::create($validated);

    if ($request->has('service_id')) {
        $booking->services()->attach($request->input('service_id'));
    }



        // ✅ Send Telegram notification
    $botToken = config('services.telegram.bot_token');
$chatId   = config('services.telegram.chat_id');

if ($botToken && $chatId) {

  $message = "🆕 <b>New Customer Booking</b>\n\n"
    . "👤 <b>Name:</b> " . htmlspecialchars($booking->name) . "\n\n"
    . "📞 <b>Phone:</b> " . htmlspecialchars($booking->phone) . "\n\n"
    . "📅 <b>Date:</b> " . \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') . "\n\n"
    . "⏰ <b>Time:</b> " . \Carbon\Carbon::parse($booking->booking_time)->format('g A') . "\n\n"
    . "💆 <b>Service:</b> " . $booking->services->map(fn($s) => htmlspecialchars($s->name))->implode(', ') . "\n\n"
    . "📝 <b>Note:</b> " . htmlspecialchars($booking->note) . "\n\n"
    . "📍 <b>Branch:</b> " . htmlspecialchars($booking->branch->name);

    Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
        'chat_id'    => $chatId,
        'text'       => $message,
        'parse_mode' => 'HTML'
    ]);

    return back()->with('success', 'ok');
}

//    return response()->json([
//        'success' => true,
//        'message' => 'Booking created successfully!',
//        'data' => [
//            'booking_id' => $booking->id,
//            'name' => $booking->name,
//            'branch' => $booking->branch->name,
//            'all' => $validated,
//        ],
//    ], 200);
}


    public function formupdate($id){
                        $booking = Booking::findOrFail($id);
                        $services = Service::all();
                        $branches  = Branch::all();
        return view('Backend.Booking.Update',compact('booking','services','branches'));
    }


            public function update(Request $request, $id)
            {
                        $request->validate([
                            'name' => 'required|string|max:255',
                            'phone' => 'required|string|max:20',
                            'branch_id' => 'required|exists:branches,id',
                            'service_id' => 'required|array|min:1', // Ensure at least one service is selected
                            'service_id.*' => 'exists:services,id', // Validate each service ID
                            'know_through' => 'nullable|in:1,2,3,4,5,6',
                            'booking_date' => 'required|date',
                            'booking_time' => 'required',
                            'status' => 'required|in:confirmed,processing,cancel',
                            'note' => 'nullable|string',
                            'payment'=>'nullable',
                            'feedback'=>'nullable|in:yes,no,empty',
                           'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', 
                        ]);

                        try {
                            $booking = Booking::findOrFail($id); // Find the existing booking

                            // $booking->user_id = auth()->id();
                            $booking->name = $request->name;
                            $booking->phone = $request->phone;
                            $booking->branch_id = $request->branch_id;
                            $booking->know_through = $request->know_through;
                            $booking->booking_date = $request->booking_date;
                            $booking->booking_time = $request->booking_time;
                            $booking->status = $request->status;
                            $booking->note = $request->note;
                            $booking->payment = $request->payment;
                            $booking->feedback = $request->feedback;

                           if ($request->hasFile('image')) {

                            if ($booking->image && file_exists(public_path('Booking/' . $booking->image))) {
                            @unlink(public_path('Booking/' . $booking->image));
                                }

                      
                                $file = $request->file('image');
                                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                                $file->move(public_path('Booking'), $filename);

                                $booking->image = $filename;
                            }
                            $booking->save();

                            if ($request->has('service_id')) {
                                $booking->services()->sync($request->input('service_id')); // Sync updates the pivot table
                            } else {
                                $booking->services()->detach(); // Remove all services if none selected
                            }

                            return redirect()->route('list.booking')->with('success', 'Booking updated successfully.');
                        } catch (\Exception $e) {
                            return back()->withInput()->with('error', 'Error updating booking: ' . $e->getMessage());
                }
}
    public function view($id)
{
                        $booking = Booking::findOrFail($id);
                        $services = Service::all();
                        $branches = Branch::all();

                        return view('Backend.Booking.View', compact('booking', 'services', 'branches'));
}

public function delete($id)
{
    $booking = Booking::findOrFail($id);
    $booking->delete();

    return redirect()->route('list.booking')->with('success', 'Booking deleted successfully.');
}


}
