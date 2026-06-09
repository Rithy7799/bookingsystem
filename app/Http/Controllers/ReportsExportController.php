<?php

namespace App\Http\Controllers;

use App\Exports\ReportsExport;
use App\Models\Booking;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ReportsExportController extends Controller
{
  

public function Export(Request $request)
{
    $from = $request->from_date ? Carbon::parse($request->from_date) : Carbon::now()->startOfMonth();
    $to   = $request->to_date   ? Carbon::parse($request->to_date)   : Carbon::now()->endOfMonth();

    $query = Booking::with(['branch','services'])
        ->whereBetween('booking_date', [$from,$to]);

    if ($request->branch_id) {
        $query->where('branch_id', $request->branch_id);
    }

    $rows = $query->orderBy('booking_date','desc')->get();

    $fileName = 'report_' . $from->format('Ymd') . '_' . $to->format('Ymd') . '.xlsx';

    // This must be the ONLY return
    return Excel::download(new ReportsExport($rows), $fileName);
}

}
