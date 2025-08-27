<?php

namespace App\Http\Controllers;

use App\Models\area_scope;
use App\Models\treasurer;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TreasurerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loggedInScopeId = auth()->user()->usr_scope_id;

    // Ambil bendahara hanya dari RT yang sama
    $treasurer = User::role('treasurer')
        ->whereHas('treasurer', function ($query) use ($loggedInScopeId) {
            $query->where('trs_area_id', $loggedInScopeId);
        })
        ->with('treasurer.areaScope')
        ->first();
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('rt_leader.treasurer.index', compact('treasurer'));
    }

    public function create()
    {
        $rtArea = auth()->user()->areaScope; // ambil scope RT user login
    return view('rt_leader.treasurer.create', compact('rtArea'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usr_id' => 'required|exists:users,usr_id',
            'asc_id' => 'required|exists:area_scopes,asc_id',
        ]);

        $user = User::where('usr_id', $request->usr_id)->firstOrFail();

        if ($user->hasRole('citizen')) {
            $user->removeRole('citizen');
        }

        $user->assignRole('treasurer');

        Treasurer::create([
            'trs_name_id' => $user->usr_id,
            'trs_area_id' => $request->asc_id,
        ]);

        return redirect()->route('treasurer.index')->with('success', 'Berhasil menjadikan bendahara!');
    }

    public function getCitizens(Request $request, $asc_id)
    {
        $search = request('term'); // ← ambil keyword pencarian dari select2

    $citizens = User::where('usr_scope_id', $asc_id)
        ->role('citizen')
        ->where('status', 1)
        ->when($search, function ($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->select('usr_id', 'first_name', 'last_name')
        ->get()
        ->map(function ($citizen) {
            return [
                'id' => $citizen->usr_id,
                'text' =>trim($citizen->first_name . ' ' . $citizen->last_name)
            ];
        });

    return response()->json($citizens);
    }


    /**
     * Display the specified resource.
     */
    public function show(treasurer $treasurer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(treasurer $treasurer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, treasurer $treasurer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $treasurer = Treasurer::findOrFail($id);

    // Cari user terkait
    $user = User::where('usr_id', $treasurer->trs_name_id)->first();

    if ($user) {
        // Hapus role "treasurer"
        if ($user->hasRole('treasurer')) {
            $user->removeRole('treasurer');
        }

        // Assign role "citizen" kembali
        $user->assignRole('citizen');
    }

    // Hapus data di tabel treasurers
    $treasurer->delete();

    return response()->json(['success' => 'Bendahara berhasil dijadikan warga.']);

    }}
