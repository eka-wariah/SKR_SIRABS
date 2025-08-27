<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\area_scope;
use App\Models\registration_water;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RwDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $jumlahRT = area_scope::where('asc_level', 'RT')->count();
    $jumlahWarga = User::role('citizen')->where('status', 1)->count();
    $jumlahPenggunaAir = registration_water::where('rgw_status', 'aktif')->count();

    $rtData = area_scope::where('asc_level', 'RT')->orderBy('asc_number')->get();
    $rtStats = [];

    foreach ($rtData as $rt) {
        $jumlah = User::role('citizen')
                      ->where('usr_scope_id', $rt->asc_id)
                      ->where('status', 1)
                      ->count();

        $rtStats[] = [
            'label' => 'RT ' . str_pad($rt->asc_number, 2, '0', STR_PAD_LEFT),
            'jumlah' => $jumlah
        ];
    }

    $chartLabels = collect($rtStats)->pluck('label');
    $chartData = collect($rtStats)->pluck('jumlah');

    return view('rw_leader.dashboard', compact(
        'jumlahRT', 'jumlahWarga', 'jumlahPenggunaAir',
        'rtStats', 'chartLabels', 'chartData'
    ));
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
