<?php

namespace App\Http\Controllers;

use App\Mail\WithdrawNotification;
use App\Models\area_scope;
use App\Models\User;
use App\Models\WasteBankCash;
use App\Models\WasteBankWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class WasteBankWithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scopes = area_scope::all();
        $saldoTersedia = WasteBankCash::getSaldoTersedia();
        $totalSaldoWarga = User::sum('total_money');
        return view('wastebank_officer.withdraw.index', compact('scopes', 'saldoTersedia','totalSaldoWarga'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getUsersByScope($scopeId)
    {
        $users = User::where('usr_scope_id', $scopeId)
                    ->where('total_money', '>', 0)
                    ->get();
        return response()->json($users);
    }

    public function create($usr_id)
    {
        $user = User::where('usr_id', $usr_id)->firstOrFail();
        return view('wastebank_officer.withdraw.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usr_id' => 'required|exists:users,usr_id',
            'amount' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);
    

        $user = User::where('usr_id', $request->usr_id)->first();

        if ($request->amount > $user->total_money) {
            return redirect()->back()->withErrors('Saldo tidak mencukupi.');
        }

        $saldoKas = WasteBankCash::getSaldoTersedia();
        if ($request->amount > $saldoKas) {
            return redirect()->back()->withErrors('Saldo kas tidak mencukupi untuk penarikan ini.');
        }

        $user->total_money -= $request->amount;
        $user->save();

        WasteBankWithdrawal::create([
            'usr_id' => $user->usr_id,
            'amount' => $request->amount,
            'notes' => $request->notes,
        ]);

        WasteBankCash::create([
            'usr_id' => Auth::id(), // petugas bank sampah
            'type' => 'Keluar',
            'amount' => $request->amount,
            'description' => 'Penarikan saldo oleh ' . $user->name,
            'date' => now(),
        ]);

        Mail::to($user->email)->send(new WithdrawNotification($user, $request->amount));

        return redirect('/wastebank_officer/withdraw')->with('success', 'Penarikan berhasil');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(WasteBankWithdrawal $wasteBankWithdrawal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WasteBankWithdrawal $wasteBankWithdrawal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WasteBankWithdrawal $wasteBankWithdrawal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WasteBankWithdrawal $wasteBankWithdrawal)
    {
        //
    }
}
