<?php

namespace App\Http\Controllers;

use App\Models\Product;
use DateTimeInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
public function list(Request $request): View
{
    $q        = trim((string) $request->input('q', ''));
    $period   = $request->string('period', 'this_week')->toString();
    $fromDate = $request->date('from');
    $toDate   = $request->date('to');
    $perPage  = (int) $request->integer('per_page', 50);

    [$from, $to, $rangeLabel] = $this->resolveRange($period, $fromDate, $toDate);

    $base = Product::query()
        ->when($q !== '', fn ($qq) =>
            $qq->where(fn ($w) =>
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('customer', 'like', "%{$q}%")
                  ->orWhere('memo', 'like', "%{$q}%")
            )
        );

    // your paginated list
    $products = (clone $base)
        ->whereBetween('created_at', [$from, $to])
        ->select(['id','customer','name','qty','price','total','memo','created_at'])
        ->orderByDesc('id')
        ->paginate($perPage)
        ->withQueryString();

    // your top products
    $tops = (clone $base)
        ->whereBetween('created_at', [$from, $to])
        ->selectRaw('name, SUM(qty) as qty_sum, SUM(total) as revenue')
        ->groupBy('name')
        ->havingRaw('SUM(qty) >= ?', [2])
        ->orderByDesc('revenue')
        ->get();

    // 👉 real total qty of ALL products in this range
    $totalProductsQty = (clone $base)
        ->whereBetween('created_at', [$from, $to])
        ->sum('qty');

    $totalRevenue = (float) $tops->sum('revenue');
    $totalQty     = (int) $tops->sum('qty_sum');

    $topProducts = $tops->map(function ($row) use ($totalRevenue) {
        $percent = $totalRevenue > 0 ? round(((float) $row->revenue / $totalRevenue) * 100, 2) : 0.0;
        return (object) [
            'name'     => (string) $row->name,
            'qty_sum'  => (int) $row->qty_sum,
            'revenue'  => (float) $row->revenue,
            'percent'  => $percent,
        ];
    });

    // ... your week stuff stays the same
    [$thisWs, $thisWe, $thisWeekLabel] = $this->weekRangeLabel(0);
    [$lastWs, $lastWe, $lastWeekLabel] = $this->weekRangeLabel(-1);

    $thisWeekRevenue = $this->sumRevenueFor($base, $thisWs, $thisWe);
    $lastWeekRevenue = $this->sumRevenueFor($base, $lastWs, $lastWe);

    $wowAbs = round($thisWeekRevenue - $lastWeekRevenue, 2);
    $wowPct = $lastWeekRevenue > 0
        ? round(($wowAbs / $lastWeekRevenue) * 100, 2)
        : ($thisWeekRevenue > 0 ? 100.00 : 0.00);

    return view('Backend.Product.List', [
        'q'                => $q,
        'period'           => $period,
        'from'             => $from->toDateString(),
        'to'               => $to->toDateString(),
        'rangeLabel'       => $rangeLabel,
        'products'         => $products,
        'topProducts'      => $topProducts,
        'totalRevenue'     => $totalRevenue,
        'totalQty'         => $totalQty,
        'totalProductsQty' => (int) $totalProductsQty,   // 👉 pass to blade
        'thisWeekLabel'    => $thisWeekLabel,
        'lastWeekLabel'    => $lastWeekLabel,
        'thisWeekRevenue'  => $thisWeekRevenue,
        'lastWeekRevenue'  => $lastWeekRevenue,
        'wowAbs'           => $wowAbs,
        'wowPct'           => $wowPct,
    ]);
}


    private function resolveRange(string $period, ?DateTimeInterface $from, ?DateTimeInterface $to): array
    {
        $tz  = 'Asia/Phnom_Penh';
        $now = Carbon::now($tz);

        if ($period === 'last_week') {
            $start = $now->copy()->subWeek()->startOfWeek(Carbon::MONDAY)->startOfDay();
            $end   = $now->copy()->subWeek()->endOfWeek(Carbon::SUNDAY)->endOfDay();
            return [$start, $end, $this->labelFor($start, $end)];
        }

        if ($period === 'custom' && $from && $to) {
            $f = Carbon::parse($from, $tz)->startOfDay();
            $t = Carbon::parse($to, $tz)->endOfDay();
            return [$f, $t, $this->labelFor($f, $t)];
        }

        $start = $now->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
        $end   = $now->copy()->endOfWeek(Carbon::SUNDAY)->endOfDay();
        return [$start, $end, $this->labelFor($start, $end)];
    }

    private function labelFor(Carbon $from, Carbon $to): string
    {
        if ($from->isSameMonth($to) && $from->isSameYear($to)) {
            return $from->isoFormat('MMM D') . ' → ' . $to->isoFormat('MMM D, YYYY');
        }
        return $from->isoFormat('MMM D, YYYY') . ' → ' . $to->isoFormat('MMM D, YYYY');
    }

    private function weekRangeLabel(int $weekOffset = 0): array
    {
        $tz   = 'Asia/Phnom_Penh';
        $now  = Carbon::now($tz)->addWeeks($weekOffset);
        $from = $now->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
        $to   = $now->copy()->endOfWeek(Carbon::SUNDAY)->endOfDay();
        return [$from, $to, $this->labelFor($from, $to)];
    }

    private function sumRevenueFor($baseBuilder, Carbon $from, Carbon $to): float
    {
        return (float) (clone $baseBuilder)
            ->whereBetween('created_at', [$from, $to])
            ->sum('total');
    }

    public function add(): View
    {
        return view('Backend.Product.Add');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer'  => ['required', 'string', 'max:255'],
            'name'      => ['required', 'string', 'max:255'],
            'price'     => ['required', 'numeric', 'min:0'],
            'qty'       => ['required', 'integer', 'min:0'],
            'memo'      => ['nullable', 'string', 'max:255'],
        ]);

        $data['total'] = round(((float) $data['price']) * ((int) $data['qty']), 2);

        Product::create($data);

        return redirect()
            ->route('list.product')
            ->with('success', 'Product created successfully.');
    }

    public function select(Product $product): View
    {
        return view('Backend.Product.Update', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'customer'  => ['required', 'string', 'max:255'],
            'name'      => ['required', 'string', 'max:255'],
            'price'     => ['required', 'numeric', 'min:0'],
            'qty'       => ['required', 'integer', 'min:0'],
            'memo'      => ['nullable', 'string', 'max:255'],
        ]);

        $data['total'] = round(((float) $data['price']) * ((int) $data['qty']), 2);

        $product->update($data);

        return redirect()
            ->route('list.product')
            ->with('success', 'Product updated successfully.');
    }

    public function delete(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('list.product')
            ->with('success', 'Product deleted successfully.');
    }
}
