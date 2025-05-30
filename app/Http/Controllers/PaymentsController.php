<?php

namespace App\Http\Controllers;

use App\Models\payments;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user(); // ambil user yang sedang login
        $saldoBankSampah = $user->total_money;
        return view('citizen.payment.index', compact('saldoBankSampah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('citizen.payment.create');
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
    public function show(payments $payments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payments $payments)
    {
        //
    }
}
