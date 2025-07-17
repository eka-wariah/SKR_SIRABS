<?php

namespace App\Http\Controllers;

use App\Models\area_scope;
use App\Models\User;
use Illuminate\Http\Request;

class RTController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataRT = User::role('rt_leader')
        ->with('areaScope')
        ->get();

        $areaScopes = area_scope::where('asc_level', 'RT')->get();

    return view('rw_leader.data_rt.index', compact('dataRT', 'areaScopes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       // Ambil semua scope_id dari user yang sudah jadi RT
    $usedScopeIds = User::role('rt_leader')->pluck('usr_scope_id');

    // Ambil wilayah RT yang belum dipakai
    $areaScopes = area_scope::where('asc_level', 'RT')
        ->whereNotIn('asc_id', $usedScopeIds)
        ->get();

        return view('rw_leader.data_rt.create', compact('areaScopes'));
    }

    public function getCitizens($asc_id)
{
    $citizens = User::role('citizen')
    ->where('usr_scope_id', $asc_id)
    ->select('usr_id', 'name') 
    ->get();

    return response()->json($citizens);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
    $request->validate([
        'area_scope_id' => 'required|exists:area_scopes,asc_id',
        'usr_id' => 'required|exists:users,usr_id',
    ]);

    // Update role user jadi 'ketua_rt' (misal)
   
    $user = User::find($request->usr_id);
    $user->usr_scope_id = $request->area_scope_id;
    $user->save();

    $user->assignRole('rt_leader');

    return redirect('/rw_leader/data_rt')->with('success', 'Pendaftaran berhasil dikirim.');
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
        $user = User::findOrFail($id);

    // Hapus role ketua RT
    if ($user->hasRole('rt_leader')) {
        $user->removeRole('rt_leader');
    }

    // Set ulang jadi 'citizen'
    $user->assignRole('citizen');
     // Atau soft delete, tergantung sistem
     return response()->json([
        'success' => 'Data RT berhasil dihapus dan diubah jadi warga.'
    ]);
    }
}
