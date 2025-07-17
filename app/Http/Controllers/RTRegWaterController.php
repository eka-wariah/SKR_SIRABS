<?php

namespace App\Http\Controllers;

use App\Models\registration_water;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RTRegWaterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $pengajuan = registration_water::with('applicant')
            ->where('rgw_status', '!=', 'Aktif')
            ->whereHas('applicant', function ($q) use ($user) {
                $q->where('usr_scope_id', $user->usr_scope_id);
            })
            ->latest()
            ->get();

        return view('rt_leader.registration_water.index', compact('pengajuan'));
    }

    public function verifikasi($id, Request $request)
    {
        $data = registration_water::findOrFail($id);
        $data->update([
            'rgw_status' => $request->status,
            'rgw_verified_by' => Auth::id(),
            'rgw_verified_at' => now(),
        ]);

        return back()->with('success', 'Status berhasil diperbarui.');
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
        $pengajuan = registration_water::with('applicant')->findOrFail($id);
        return view('rt_leader.registration_water.show', compact('pengajuan'));
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
        $request->validate(['rgw_status' => 'required']);
        $pengajuan = registration_water::findOrFail($id);
        $pengajuan->update([
        'rgw_status' => $request->rgw_status,
        'rgw_verified_by' => Auth::user()->usr_id,
        'rgw_verified_at' => now(),
    ]);

    return redirect()->route('rt_leader.registration_water.index')->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
