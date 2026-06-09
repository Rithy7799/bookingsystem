<?php

namespace App\Http\Controllers;

use App\Models\BookingandContacts;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingandContactController extends Controller
{
   public function list(Request $request)
{
    $q      = trim((string) $request->input('q', ''));
    $period = $request->string('period', 'this_week')->toString();
    $fromIn = $request->date('from');
    $toIn   = $request->date('to');

    $tz  = 'Asia/Phnom_Penh';
    $now = Carbon::now($tz);

    if ($period === 'last_week') {
        $from = $now->copy()->startOfWeek()->subWeek();
        $to   = $from->copy()->endOfWeek();
        $rangeLabel = 'Last Week';
    } elseif ($period === 'custom' && $fromIn && $toIn) {
        $from = Carbon::parse($fromIn, $tz)->startOfDay();
        $to   = Carbon::parse($toIn,   $tz)->endOfDay();
        $rangeLabel = $from->format('Y-m-d') . ' → ' . $to->format('Y-m-d');
    } else {
        $from = $now->copy()->startOfWeek();
        $to   = $now->copy()->endOfWeek();
        $rangeLabel = 'This Week';
    }

    $base = BookingandContacts::query()
        ->when($q !== '', function ($query) use ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('booking', 'like', "%{$q}%")
                   ->orWhere('contact', 'like', "%{$q}%")
                   ->orWhere('note', 'like', "%{$q}%");
            });
        })
        ->when($from && $to, fn($qq) => $qq->whereBetween('created_at', [$from, $to]));

    // count rows (just info)
    $totalRows = (clone $base)->count();

    // ✅ sum the numeric values
    $totalBooking = (clone $base)->sum('booking'); // ex: 50 + 30 + 20 = 100
    $totalContact = (clone $base)->sum('contact'); // ex: 40 + 10 = 50

    // metrics
    $delta = $totalBooking - $totalContact;
    $ratio = ($totalBooking + $totalContact) > 0
        ? round(($totalBooking / ($totalBooking + $totalContact)) * 100)
        : 0;

    $items = $base->latest('id')->paginate(10)->withQueryString();

    return view('Backend.BookingandContact.List', compact(
        'items', 'q', 'period', 'from', 'to', 'rangeLabel',
        'totalRows', 'totalBooking', 'totalContact', 'delta', 'ratio'
    ));
}

    public function add()
    {
        return view('Backend.BookingandContact.Add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'booking' => ['required','string','max:255'],
            'contact' => ['required','string','max:255'],
            'note'    => ['nullable','string','max:1000'],
        ]);

        BookingandContacts::create($data);

        return redirect()
            ->route('bookingandcontact.list')
            ->with('success', 'Created successfully.');
    }

    public function select($id)
    {
        $bookingandcontact = BookingandContacts::findOrFail($id);
        return view('Backend.BookingandContact.Update', compact('bookingandcontact'));
    }

 public function update(Request $request)
{
    $data = $request->validate([
        'id'      => ['required','integer','exists:bookingand_contacts,id'],
        'booking' => ['required','integer','min:0'],
        'contact' => ['required','integer','min:0'],
        'note'    => ['nullable','string','max:1000'],
    ]);

    $row = BookingandContacts::findOrFail($data['id']);
    $row->update([
        'booking' => $data['booking'],
        'contact' => $data['contact'],
        'note'    => $data['note'] ?? null,
    ]);

    return redirect()->route('bookingandcontact.list')->with('success', 'Updated.');
}


        public function delete(Request $request)
        {
            $id = $request->input('id');

            $bookingandcontact = BookingandContacts::findOrFail($id);
            $bookingandcontact->delete();

            return redirect()
                ->route('bookingandcontact.list')
                ->with('success', 'Deleted successfully.');
        }

}
