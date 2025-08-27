<?php

namespace App\Http\Controllers;

use App\Mail\UserAprovedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CitizenApproveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rtId = auth()->user()->usr_scope_id;
        $pendingUsers = User::role('citizen')->where('status', 0)->where('usr_scope_id', $rtId)->get();
        return view('rt_leader.approve.index', compact('pendingUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */

     public function approve($id)
     {
         $user = User::findOrFail($id);
         $user->status = 1;
         $user->save();
 
         // Kirim email notifikasi
         Mail::to($user->email)->send(new UserAprovedMail($user));
 
         return back()->with('success', 'Akun warga berhasil disetujui.');
     }
     
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
