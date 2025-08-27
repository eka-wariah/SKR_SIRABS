<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\payments;
use App\Models\registration_water;
use App\Models\User;
use App\Models\waste_bank_details;
use Illuminate\Http\Request;

class CitizenDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user(); // ambil user yang sedang login
        $saldoBankSampah = $user->total_money; // ambil saldo dari kolom total_money
        $totalBeratSampah = waste_bank_details::whereHas('wasteBank', function ($query) use ($user) {
            $query->where('wtb_name_id', $user->usr_id);
        })->sum('berat');
        $airRegistration = registration_water::where('rgw_household_id', $user->household_id)->first();

        $ketuaRT = User::where('usr_scope_id', $user->usr_scope_id)
        ->whereHas('roles', fn ($q) => $q->where('name', 'rt_leader')) // jika pakai Spatie
        ->first();
        $user = auth()->user();

    $invoices = Invoice::with('paymentCategory')
    ->where('household_id', $user->household_id)
        ->where('status', 'pending')
        ->orderBy('periode', 'desc')
        ->get();
        
        $payments = payments::where('pyn_household_id', $user->household_id)
        ->latest()
        ->limit(5)
        ->get();

        // dd($invoices); 
        return view('citizen.dashboard', compact('saldoBankSampah', 'airRegistration', 'ketuaRT', 'totalBeratSampah', 'payments', 'invoices'));
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
    public function show(string $id)
    {
        //
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
