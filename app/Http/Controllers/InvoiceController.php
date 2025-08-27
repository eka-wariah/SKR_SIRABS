<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use App\Models\PaymentCategory;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoicePaidMail;
use App\Models\payment_category;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $user = Auth::user();

    //     // Pastikan role bendahara
    //     if (!$user->hasRole('treasurer')) {
    //         abort(403, 'Akses ditolak');
    //     }

    //     // Ambil invoice khusus RT bendahara ini
    //     $invoices = Invoice::with(['household.users', 'paymentCategory'])
    //         ->forTreasurer($user->usr_id)
    //         ->latest()
    //         ->paginate(10);

    //     return view('treasurer.invoices.index', compact('invoices'));
    // }

    public function index(Request $request)
{
    $user = Auth::user();

    if (!$user->hasRole('treasurer')) {
        abort(403, 'Akses ditolak');
    }

    // Request AJAX dari DataTables
    if ($request->ajax()) {
        $query = Invoice::with(['household.users', 'paymentCategory'])
            ->forTreasurer($user->usr_id)
            ->when($request->year, fn($q) => $q->whereYear('created_at', $request->year))
            ->when($request->month, fn($q) => $q->whereMonth('created_at', $request->month))
            ->when($request->status, fn($q) => $q->where('status', $request->status)) // cuma filter kalau ada request status
            ->latest();

        return datatables()->of($query)
            ->addColumn('warga', fn($row) => $row->owner()?->name ?? '-')
            ->editColumn('formatted_amount', fn($row) => $row->formatted_amount)
            ->editColumn('status', function ($row) {
                return match ($row->status) {
                    'pending' => 'Belum Dibayar',
                    'lunas'   => 'Lunas',
                    default   => ucfirst($row->status),
                };
            })
            ->make(true);
    }

    return view('treasurer.invoices.index');
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $user = Auth::user();

        // Pastikan invoice termasuk di household user yang sama
        $invoice = Invoice::where('inv_id', $id)
            ->where('household_id', $user->household_id)
            ->with(['household.users'])
            ->firstOrFail();
        
            $treasurer = User::where('usr_scope_id', $user->usr_scope_id)
        ->whereHas('roles', fn($q) => $q->where('name', 'treasurer'))
        ->with('household')
        ->first();

        $household = $user->household;
        
        return view('citizen.invoice.show', compact('invoice', 'treasurer', 'user', 'household'));
}

    /**
     * Generate invoice otomatis untuk semua warga sesuai kategori dan periode berjalan.
     * Bisa dipanggil manual via route khusus oleh admin atau petugas.
     */
    public function generate()
    {
        $periode = now()->format('Y-m');
        $categories = payment_category::all();

        foreach ($categories as $category) {
            if ($category->name == 'sampah') {
                $wargas = User::where('status', 1)
                    ->whereDoesntHave('invoices', function($q) use ($periode, $category) {
                        $q->where('pyn_periode', $periode)
                          ->where('payment_category_id', $category->id);
                    })
                    ->get();

            } elseif ($category->name == 'air') {
                $wargas = User::where('status', 1)
                    ->where('is_air', true)
                    ->whereDoesntHave('invoices', function($q) use ($periode, $category) {
                        $q->where('pyn_periode', $periode)
                          ->where('payment_category_id', $category->id);
                    })
                    ->get();
            } else {
                $wargas = User::where('status', 1)
                    ->whereDoesntHave('invoices', function($q) use ($periode, $category) {
                        $q->where('pyn_periode', $periode)
                          ->where('payment_category_id', $category->id);
                    })
                    ->get();
            }

            foreach ($wargas as $warga) {
                $amount = $category->amount;

                // Hitung prorata jika daftar di bulan ini
                $tanggalDaftar = $warga->created_at;
                if ($tanggalDaftar->format('Y-m') == $periode) {
                    $amount = $this->hitungProrataAmount($category->amount, $tanggalDaftar);
                }

                $invoiceNumber = 'INV-' . strtoupper(uniqid());

                Invoice::create([
                    'inv_usr_id' => $warga->usr_id,
                    'payment_category_id' => $category->id,
                    'invoice_number' => $invoiceNumber,
                    'periode' => $periode,
                    'due_date' => now()->endOfMonth(),
                    'amount' => $amount,
                    'status' => 'unpaid',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Invoice berhasil digenerate.');
    }

    /**
     * Fungsi hitung prorata tagihan
     */
    private function hitungProrataAmount($totalAmount, $tanggalDaftar)
    {
        $totalHari = now()->daysInMonth;
        $tanggalDaftarCarbon = \Carbon\Carbon::parse($tanggalDaftar);
        $hariSisa = $totalHari - $tanggalDaftarCarbon->day + 1;

        $prorata = ($totalAmount * $hariSisa) / $totalHari;

        return ceil($prorata);
    }

    public function pdf($id)
    {
        $user = Auth::user();
        $invoice = Invoice::where('inv_usr_id', $user->usr_id)
            ->where('inv_id', $id)
            ->firstOrFail();

        $pdf = PDF::loadView('citizen.invoices.pdf', compact('invoice'));

        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function payNow(Request $request, $id)
    {
        $user = Auth::user();
        $invoice = Invoice::where('inv_usr_id', $user->usr_id)
            ->where('inv_id', $id)
            ->firstOrFail();

        // -- 1) proses pembayaran (mock) -- 
        // (sesuaikan dengan flow pembayaran sebenarnya)
        $paymentId = DB::table('payments')->insertGetId([
            'pyn_household_id' => $user->household_id,
            'pyn_paid_by' => $user->usr_id,
            'pyn_treasurer_id' => null,
            'pyn_payment_category_id' => null,
            'jumlah_bayar' => $invoice->amount,
            'metode_bayar' => 'digital',
            'status' => 'lunas',
            'pyn_status_submission' => 'Sudah Dikonfirmasi',
            'pyn_periode' => $invoice->periode,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // -- 2) update invoice jadi paid -- 
        $invoice->update(['status' => 'paid']);

        // -- 3) kirim email konfirmasi (opsional) -- 
        if ($user->email) {
            Mail::to($user->email)->send(new InvoicePaidMail($invoice));
        }

        return redirect()->route('citizen.invoices.index')->with('success', 'Pembayaran berhasil. Invoice dilunasi.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
