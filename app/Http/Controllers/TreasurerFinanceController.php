<?php

namespace App\Http\Controllers;

use App\Models\payment_category;
use App\Models\payments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreasurerFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = Auth::user();
        $households = User::where('usr_scope_id', $user->usr_scope_id)
                  ->pluck('household_id')
                  ->unique();
        $paymentCategories = payment_category::all(); 
        $payments = payments::with('paymentCategory', 'household')
            ->where('pyn_treasurer_id', $user->usr_id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                // Tentukan jenis catatan: pemasukan / pengeluaran
                $item->tipe = $item->pyn_payment_category_id ? 'Pemasukan' : 'Pengeluaran';
    
                // Kategori: air / sampah (untuk pengeluaran, ambil dari sys_note)
                if ($item->pyn_payment_category_id) {
                    $item->kategori = stripos($item->paymentCategory->pym_name ?? '', 'air') !== false
                        ? 'Air'
                        : (stripos($item->paymentCategory->pym_name ?? '', 'sampah') !== false ? 'Sampah' : 'Lainnya');
                } else {
                    $item->kategori = ucfirst($item->pyn_sys_note); // air / sampah
                }
    
                return $item;
            });
    
        return view('treasurer.finance.index', compact('payments', 'households', 'paymentCategories'));
    
    }
    // public function index()
    // {
    //     $user = Auth::user();

    //     $payments = payments::with('paymentCategory', 'household')
    //         ->where('pyn_treasurer_id', $user->usr_id)
    //         ->get();

    //     $expenses = $payments->where('pyn_payment_category_id', null); // pengeluaran: kategori null

    //     // Pakai filter + stripos agar fleksibel jika nama berubah
    //     $airPayments = $payments->filter(function ($item) {
    //         return stripos($item->paymentCategory->pym_name ?? '', 'air') !== false;
    //     });

    //     $sampahPayments = $payments->filter(function ($item) {
    //         return stripos($item->paymentCategory->pym_name ?? '', 'sampah') !== false;
    //     });

    //     // Hitung total & potongan
    //     $airTotal = $airPayments->sum('jumlah_bayar');
    //     $airPotongan = $airTotal * 0.10; // hanya air yang ada potongan 10%
    //     $airPengeluaran = $expenses->where('pyn_sys_note', 'air')->sum('jumlah_bayar');
    //     $airSaldo = $airTotal - $airPotongan - $airPengeluaran;

    //     $sampahTotal = $sampahPayments->sum('jumlah_bayar');
    //     $sampahPengeluaran = $expenses->where('pyn_sys_note', 'sampah')->sum('jumlah_bayar');
    //     $sampahSaldo = $sampahTotal - $sampahPengeluaran;

    //     $paymentCategories = payment_category::all();
    //     $households = User::where('usr_scope_id', $user->usr_scope_id)->pluck('household_id')->unique();

    //     return view('treasurer.finance.index', compact(
    //         'payments', 'airTotal', 'airPotongan', 'airPengeluaran', 'airSaldo',
    //         'sampahTotal', 'sampahPengeluaran', 'sampahSaldo', 'paymentCategories', 'households'
    //     ));
    // }

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
    public function storePayment(Request $request)
    {
        $request->validate([
            'household_id' => 'required',
            'jumlah_bayar' => 'required|numeric',
            'pyn_payment_category_id' => 'required',
        ]);
        $paymentCategories = payment_category::all(); 
        payments::create([
            'pyn_household_id' => $request->household_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'pyn_treasurer_id' => Auth::user()->usr_id,
            'pyn_payment_category_id' => $request->pyn_payment_category_id,
            'metode_bayar' => 'offline',
            'status' => 'lunas',
            'pyn_periode' => now()->format('Y-m'),
        ]);

        return back()->with('success', 'Pembayaran berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function StoreExpense(Request $request)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric',
            'keterangan' => 'required|in:air,sampah',
        ]);
    
        payments::create([
            'pyn_household_id' => Auth::user()->usr_scope_id, // tetap isi dengan scope wilayah
            'jumlah_bayar' => $request->jumlah_bayar,
            'pyn_treasurer_id' => Auth::user()->usr_id,
            'pyn_payment_category_id' => null, // karena ini pengeluaran, tidak perlu kategori
            'metode_bayar' => 'internal',
            'status' => 'lunas',
            'pyn_periode' => now()->format('Y-m'),
            'pyn_sys_note' => $request->keterangan, // 'air' atau 'sampah'
        ]);
    
        return back()->with('success', 'Pengeluaran berhasil ditambahkan.');
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
