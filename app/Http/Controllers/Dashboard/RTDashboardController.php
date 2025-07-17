<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\households;
use App\Models\User;
use Illuminate\Http\Request;

class RTDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scopeId = auth()->user()->usr_scope_id;

    // Jumlah warga sesuai area RT login
    $jumlahWarga = User::where('usr_scope_id', $scopeId)
                    
                        ->count();

    // Ambil semua household_id milik warga di area RT
    $householdIds = User::where('usr_scope_id', $scopeId)
                        ->pluck('household_id')
                        ->unique();

    // Hitung jumlah KK unik berdasarkan household_id
    $jumlahKK = households::whereIn('id', $householdIds)->count();

    return view('rt_leader.dashboard', [
        'jumlahWarga' => $jumlahWarga,
        'jumlahKK' => $jumlahKK,
    ]);
    
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
