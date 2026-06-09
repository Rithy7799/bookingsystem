<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ReportController extends Controller
{
    public function Report(Request $request)
    {
        $data = $this->buildReportData($request);
        return view('Backend.Report.List', $data);
    }

    /**
     * Print report (opens in new tab)
     */
    public function Print(Request $request)
    {
        $cacheKey = 'report:print:' . md5(json_encode([
            'from'      => $request->input('from_date'),
            'to'        => $request->input('to_date'),
            'branch_id' => $request->input('branch_id'),
            'period'    => $request->input('period'),
            'user'      => optional($request->user())->id,
        ]));

        $data = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($request) {
            return $this->buildReportData($request);
        });

        return view('Backend.Report.PrintReport', $data);
    }

    /**
     * Helper: always return a 7-day window Sunday → Saturday (no matter what).
     *
     * Example:
     *  reference = 2025-03-02 (Monday)
     *  -> Sunday = 2025-03-01
     *  -> Saturday = 2025-03-07
     */
    private function getWeekRangeFromReference(Carbon $reference): array
    {
        // dayOfWeek: 0 = Sunday, 1 = Monday, ..., 6 = Saturday
        $dow = $reference->dayOfWeek; // integer 0-6

        // Go back to Sunday of that week
        $start = $reference->copy()->subDays($dow); // Sunday

        // Saturday is 6 days after Sunday
        $end = $start->copy()->addDays(6);          // Saturday

        return [$start, $end];
    }

    /**
     * Shared dataset for List + Print (no data loss; all filters applied)
     */
    private function buildReportData(Request $request): array
    {
        // Lookups
        $branches = Branch::all();
        $services = Service::all();

        // Date range (period buttons override manual dates)
        [$from, $to] = $this->resolveDateRange($request);

        // Base query + filters (for the main period)
        $query = Booking::with(['branch', 'services'])
            ->whereBetween('booking_date', [$from, $to]);

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $bookingsData = $query->get();

        // Top-level stats (for selected period)
        $totalRevenue     = (float) $bookingsData->sum('payment');
        $totalBooking     = $bookingsData->count();
        $statusConfirmed  = $bookingsData->where('status', 'confirmed')->count();
        $statusCancelled  = $bookingsData->where('status', 'cancel')->count();
        $statusProcessing = $bookingsData->where('status', 'processing')->count();

        // Feedback (respect current filters)
        $feedbackyes   = $bookingsData->where('feedback', 'yes')->count();
        $feedbackno    = $bookingsData->where('feedback', 'no')->count();
        $feedbackempty = $bookingsData->where('feedback', 'empty')->count();

        // Revenue by Branch (desc)
        $revenueByBranch = $bookingsData
            ->groupBy('branch_id')
            ->map(fn ($rows) => (float) $rows->sum('payment'))
            ->sortDesc();

        // Revenue by Service (desc)
        $serviceRevenue = [];
        foreach ($bookingsData as $b) {
            $paid = (float) ($b->payment ?? 0);

            if ($b->relationLoaded('services') && $b->services->count() > 0) {
                $count = max(1, $b->services->count());
                foreach ($b->services as $svc) {
                    $portion = (float) ($svc->pivot->price ?? $svc->pivot->total ?? ($paid / $count));
                    $serviceRevenue[$svc->id] = ($serviceRevenue[$svc->id] ?? 0) + $portion;
                }
            } elseif (!empty($b->service_id)) {
                $serviceRevenue[$b->service_id] = ($serviceRevenue[$b->service_id] ?? 0) + $paid;
            }
        }
        $revenueByService = collect($serviceRevenue)->sortDesc();

        // UNIQUE USERS per Service (by phone, fallback name)
        $peopleSetByService = []; // service_id => [personKey => true]
        foreach ($bookingsData as $b) {
            $phone     = trim((string) ($b->phone ?? ''));
            $name      = trim((string) ($b->name  ?? '—'));
            $personKey = $phone !== '' ? 'p:' . $phone : 'n:' . $name;

            if ($b->relationLoaded('services') && $b->services->count() > 0) {
                foreach ($b->services as $svc) {
                    $sid = $svc->id;
                    $peopleSetByService[$sid] ??= [];
                    $peopleSetByService[$sid][$personKey] = true;
                }
            } elseif (!empty($b->service_id)) {
                $sid = $b->service_id;
                $peopleSetByService[$sid] ??= [];
                $peopleSetByService[$sid][$personKey] = true;
            }
        }
        $usersByService = collect($peopleSetByService)->map(fn ($set) => count($set));

        // Revenue by Know Through (desc)
        $revenueByKnowThrough = $bookingsData
            ->groupBy('know_through')
            ->map(fn ($rows) => (float) $rows->sum('payment'))
            ->sortDesc();

        // Confirmed bookings list
        $confirmedBookings = $bookingsData->where('status', 'confirmed');

        // Repeat customers (by phone; fallback name)
        $repeatCustomers = $bookingsData
            ->groupBy(function ($b) {
                $phone = trim((string) ($b->phone ?? ''));
                return $phone !== '' ? $phone : ('name:' . ($b->name ?? ''));
            })
            ->map(function ($group) {
                $first = $group->min('booking_date') ?? $group->min('created_at');
                $last  = $group->max('booking_date') ?? $group->max('created_at');
                $first = $first instanceof Carbon ? $first : Carbon::parse($first);
                $last  = $last  instanceof Carbon ? $last  : Carbon::parse($last);

                return [
                    'phone'          => $group->first()->phone ?? '—',
                    'name'           => $group->first()->name ?? '—',
                    'total_bookings' => $group->count(),
                    'first_booking'  => $first,
                    'last_booking'   => $last,
                ];
            })
            ->filter(fn ($c) => $c['total_bookings'] > 1)
            ->values();

        /**
         * Weekly revenue comparison (this week vs last week)
         * Week is ALWAYS 7 days: Sunday → Saturday.
         * Respects branch filter if selected.
         */
        $branchIdFilter = $request->filled('branch_id') ? $request->branch_id : null;

        $today = Carbon::today();

        // This week (example: 30,01,02,03,04,05,06)
        [$thisWeekStart, $thisWeekEnd] = $this->getWeekRangeFromReference($today);

        // Last week (example: 23,24,25,26,27,28,29)
        [$lastWeekStart, $lastWeekEnd] = $this->getWeekRangeFromReference(
            $today->copy()->subWeek()
        );

        $weeklyBase = Booking::query();

        if ($branchIdFilter) {
            $weeklyBase->where('branch_id', $branchIdFilter);
        }

        $thisWeekRevenue = (clone $weeklyBase)
            ->whereBetween('booking_date', [
                $thisWeekStart->toDateString(),
                $thisWeekEnd->toDateString(),
            ])
            ->sum('payment');

        $lastWeekRevenue = (clone $weeklyBase)
            ->whereBetween('booking_date', [
                $lastWeekStart->toDateString(),
                $lastWeekEnd->toDateString(),
            ])
            ->sum('payment');

        if ($lastWeekRevenue > 0) {
            $weekOverWeekChange = (($thisWeekRevenue - $lastWeekRevenue) / $lastWeekRevenue) * 100;
        } else {
            $weekOverWeekChange = null;
        }

        $weekTrend = 'flat';
        if ($thisWeekRevenue > $lastWeekRevenue) {
            $weekTrend = 'up';
        } elseif ($thisWeekRevenue < $lastWeekRevenue) {
            $weekTrend = 'down';
        }

        return compact(
            'branches',
            'services',
            'from',
            'to',
            'totalRevenue',
            'totalBooking',
            'statusConfirmed',
            'statusCancelled',
            'statusProcessing',
            'feedbackyes',
            'feedbackno',
            'feedbackempty',
            'revenueByBranch',
            'revenueByService',
            'usersByService',
            'revenueByKnowThrough',
            'confirmedBookings',
            'repeatCustomers',
            'thisWeekRevenue',
            'lastWeekRevenue',
            'weekOverWeekChange',
            'weekTrend'
        );
    }

    /**
     * Period buttons override manual dates.
     * "This week" & "Last week" = ALWAYS Sunday → Saturday.
     */
    private function resolveDateRange(Request $request): array
    {
        $from = $request->from_date
            ? Carbon::parse($request->from_date)
            : Carbon::now()->startOfMonth();

        $to = $request->to_date
            ? Carbon::parse($request->to_date)
            : Carbon::now()->endOfMonth();

        if ($request->filled('period')) {
            $today = Carbon::today();

            switch ($request->period) {
                case 'this_week':
                    [$from, $to] = $this->getWeekRangeFromReference($today);
                    break;

                case 'last_week':
                    [$from, $to] = $this->getWeekRangeFromReference(
                        $today->copy()->subWeek()
                    );
                    break;

                case 'this_month':
                    $from = $today->copy()->startOfMonth();
                    $to   = $today->copy()->endOfMonth();
                    break;

                case 'last_month':
                    $lastMonth = $today->copy()->subMonth();
                    $from      = $lastMonth->copy()->startOfMonth();
                    $to        = $lastMonth->copy()->endOfMonth();
                    break;

                case 'this_year':
                    $from = $today->copy()->startOfYear();
                    $to   = $today->copy()->endOfYear();
                    break;

                case 'last_year':
                    $lastYear = $today->copy()->subYear();
                    $from     = $lastYear->copy()->startOfYear();
                    $to       = $lastYear->copy()->endOfYear();
                    break;
            }
        }

        return [$from, $to];
    }
}
