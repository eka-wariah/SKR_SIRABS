<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WasteBankCash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WasteBankCashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cashes = WasteBankCash::with('user')->orderBy('date', 'desc')->get();

        // Hitung saldo akhir
        $saldoAkhir = WasteBankCash::sum(\DB::raw("CASE WHEN type = 'Masuk' THEN amount ELSE -amount END"));

        // Hitung saldo awal bulan ini
        $bulanIni = Carbon::now()->startOfMonth();
        $saldoAwal = WasteBankCash::where('date', '<', $bulanIni)
                        ->sum(\DB::raw("CASE WHEN type = 'Masuk' THEN amount ELSE -amount END"));

        $total = $saldoAkhir;

        return view('wastebank_officer.cashflow.index', compact('cashes', 'saldoAkhir', 'saldoAwal', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); 
        return view('wastebank_officer.cashflow.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:Masuk,Keluar',
            'amount' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);

        WasteBankCash::create([
            'usr_id' => Auth::id(), // petugas yang input
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => now(),
        ]);

        return redirect()->back()->with('success', 'Transaksi kas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(WasteBankCash $wasteBankCash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WasteBankCash $wasteBankCash)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WasteBankCash $wasteBankCash)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WasteBankCash $wasteBankCash)
    {
        //
    }
}
