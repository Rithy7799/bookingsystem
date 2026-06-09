<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function dashboard()
    {
        // initial stats for page load
        $totalBookings      = (int) Booking::count();
        $confirmedBookings  = (int) Booking::where('status', 'confirmed')->count();
        $totalRevenue       = (float) Booking::where('status', 'confirmed')->sum('payment');

        $lastWeekRevenue = (float) Booking::where('status', 'confirmed')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->sum('payment');

        $thisWeekRevenue = (float) Booking::where('status', 'confirmed')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('payment');

        $percentIncrease = 0.0;
        if ($lastWeekRevenue > 0) {
            $percentIncrease = (($thisWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100;
        } elseif ($thisWeekRevenue > 0) {
            $percentIncrease = 100.0;
        }

        $todaysBookings     = (int) Booking::whereDate('created_at', today())->count();
        $yesterdaysBookings = (int) Booking::whereDate('created_at', today()->subDay())->count();
        $trend = 0.0;
        if ($yesterdaysBookings > 0) {
            $trend = (($todaysBookings - $yesterdaysBookings) / $yesterdaysBookings) * 100;
        } elseif ($todaysBookings > 0) {
            $trend = 100.0;
        }

        $processingCount = (int) Booking::where('status', 'processing')->count();
        $cancelledCount  = (int) Booking::where('status', 'cancel')->count();

        $thisMonthPayment = (float) Booking::where('status', 'confirmed')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('payment');

        $lastMonthPayment = (float) Booking::where('status', 'confirmed')
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->sum('payment');

        return view('Backend.Index', compact(
            'thisWeekRevenue', 'lastWeekRevenue',
            'totalRevenue', 'percentIncrease',
            'confirmedBookings', 'processingCount', 'cancelledCount',
            'todaysBookings', 'trend', 'totalBookings',
            'thisMonthPayment', 'lastMonthPayment'
        ));
    }

    public function filterData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period' => 'required|in:this_week,last_week,this_month,last_month'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $period = $request->input('period');
        // Stats totals for the period
        $query = Booking::query();
        switch ($period) {
            case 'last_week':
                $startDate = now()->subWeek()->startOfWeek();
                $endDate   = now()->subWeek()->endOfWeek();
                break;
            case 'this_month':
                $startDate = now()->startOfMonth();
                $endDate   = now()->endOfMonth();
                break;
            case 'last_month':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate   = now()->subMonth()->endOfMonth();
                break;
            default: // this_week
                $startDate = now()->startOfWeek();
                $endDate   = now()->endOfWeek();
        }

        $query->whereBetween('created_at', [$startDate, $endDate]);
        $filteredBookings          = $query->get();
        $filteredConfirmedBookings = $filteredBookings->where('status', 'confirmed');

        // Today vs yesterday
        $todaysBookings     = (int) Booking::whereDate('created_at', today())->count();
        $yesterdaysBookings = (int) Booking::whereDate('created_at', today()->subDay())->count();
        $trend = 0.0;
        if ($yesterdaysBookings > 0) {
            $trend = (($todaysBookings - $yesterdaysBookings) / $yesterdaysBookings) * 100;
        } elseif ($todaysBookings > 0) {
            $trend = 100.0;
        }

        // Percent increase for revenue
        $lastWeekRevenue = (float) Booking::where('status', 'confirmed')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->sum('payment');
        $thisWeekRevenue = (float) Booking::where('status', 'confirmed')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('payment');
        $percentIncrease = 0.0;
        if ($lastWeekRevenue > 0) {
            $percentIncrease = (($thisWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100;
        } elseif ($thisWeekRevenue > 0) {
            $percentIncrease = 100.0;
        }

        // Build chart data arrays
        $labels         = [];
        $processingData = [];
        $confirmedData  = [];
        $cancelledData  = [];

        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            $labels[] = ($period === 'this_week' || $period === 'last_week')
                ? $current->format('D')
                : $current->format('d M');

            $dateOnly = $current->toDateString();
            $processingData[] = (int) Booking::whereDate('created_at', $dateOnly)->where('status', 'processing')->count();
            $confirmedData[]  = (int) Booking::whereDate('created_at', $dateOnly)->where('status', 'confirmed')->count();
            $cancelledData[]  = (int) Booking::whereDate('created_at', $dateOnly)->where('status', 'cancel')->count();

            $current->addDay();
        }

        return response()->json([
            'todaysBookings'    => $todaysBookings,
            'trend'             => round($trend, 2),
            'percentIncrease'   => round($percentIncrease, 2),
            'totalRevenue'      => (float) $filteredConfirmedBookings->sum('payment'),
            'totalBookings'     => (int)   $filteredBookings->count(),
            'confirmedBookings' => (int)   $filteredConfirmedBookings->count(),
            'processingCount'   => (int)   $filteredBookings->where('status', 'processing')->count(),
            'cancelledCount'    => (int)   $filteredBookings->where('status', 'cancel')->count(),
            'thisWeekPayment'   => (float) Booking::where('status', 'confirmed')->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('payment'),
            'lastWeekPayment'   => (float) Booking::where('status', 'confirmed')->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->sum('payment'),
            'thisMonthPayment'  => (float) Booking::where('status', 'confirmed')->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('payment'),
            'lastMonthPayment'  => (float) Booking::where('status', 'confirmed')->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->sum('payment'),

            // chart arrays
            'labels'     => $labels,
            'processing' => $processingData,
            'confirmed'  => $confirmedData,
            'cancelled'  => $cancelledData,
        ]);
    }
}
