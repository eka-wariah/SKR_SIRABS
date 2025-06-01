<?php

namespace App\Http\Controllers;

use App\Models\payment_category;
use App\Models\payment_gateway;
use App\Models\payments;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user(); // ambil user yang sedang login
        $saldoBankSampah = $user->total_money;
        $biayaYangDibutuhkan = payment_category::min('pym_total');
        $pendingPayments = payments::with(['user', 'paymentCategory']) // pastikan relasi sudah ada
        ->where('status', 'pending')
        ->get();
        return view('citizen.payment.index', compact('saldoBankSampah','biayaYangDibutuhkan', 'pendingPayments' ));
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
    public function show(payment_gateway $payment_gateway)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payment_gateway $payment_gateway)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, payment_gateway $payment_gateway)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payment_gateway $payment_gateway)
    {
        //
    }
}
