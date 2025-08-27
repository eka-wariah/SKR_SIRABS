<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\households;
use App\Models\payments;
use App\Models\registration_water;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RTDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
{
    $user = Auth::user();

    $jumlahWarga = User::role('citizen')->where('usr_scope_id', $user->usr_scope_id)->where('status', $user->status=1)->count();
    $wargaverif = User::role('citizen')->where('usr_scope_id', $user->usr_scope_id)->where('status', $user->status=0)->count();
    $jumlahKK = User::role('citizen')->where('usr_scope_id', $user->usr_scope_id)->where('status', $user->status=1)->distinct('household_id')->count('household_id');

    $pengajuanPending = registration_water::where('rgw_status', 'menunggu')
        ->whereHas('applicant', fn($q) => $q->where('usr_scope_id', $user->usr_scope_id))
        ->count();

    $totalRetribusi = payments::where('status', 'lunas')
        ->whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->whereHas('user', fn($q) => $q->where('usr_scope_id', $user->usr_scope_id))
        ->sum('jumlah_bayar');

    // Label bulan
    $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    // Pengajuan Air per Bulan
    $jumlahPengajuanPerBulan = registration_water::selectRaw('MONTH(rgw_registration_date) as bulan, COUNT(*) as total')
        ->whereYear('rgw_registration_date', now()->year)
        ->whereHas('applicant', fn($q) => $q->where('usr_scope_id', $user->usr_scope_id))
        ->groupBy('bulan')
        ->pluck('total', 'bulan');

    $jumlahPengajuanArray = [];
    for ($i = 1; $i <= 12; $i++) {
        $jumlahPengajuanArray[] = $jumlahPengajuanPerBulan[$i] ?? 0;
    }

    // Pendaftaran Warga per Bulan
    $jumlahPendaftaranPerBulan = User::role('citizen')
        ->where('usr_scope_id', $user->usr_scope_id)
        ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
        ->whereYear('created_at', now()->year)
        ->groupBy('bulan')
        ->pluck('total', 'bulan');

    $jumlahPendaftaranArray = [];
    for ($i = 1; $i <= 12; $i++) {
        $jumlahPendaftaranArray[] = $jumlahPendaftaranPerBulan[$i] ?? 0;
    }

    return view('rt_leader.dashboard', compact(
        'jumlahWarga','wargaverif', 'jumlahKK', 'pengajuanPending', 'totalRetribusi',
        'bulanLabels', 'jumlahPengajuanArray', 'jumlahPendaftaranArray'
    ));
}

     

    // public function index()
    // {
    //     $scopeId = auth()->user()->usr_scope_id;

    // // Jumlah warga sesuai area RT login
    // $jumlahWarga = User::where('usr_scope_id', $scopeId)
                    
    //                     ->count();

    // // Ambil semua household_id milik warga di area RT
    // $householdIds = User::where('usr_scope_id', $scopeId)
    //                     ->pluck('household_id')
    //                     ->unique();

    // // Hitung jumlah KK unik berdasarkan household_id
    // $jumlahKK = households::whereIn('id', $householdIds)->count();

    // return view('rt_leader.dashboard', [
    //     'jumlahWarga' => $jumlahWarga,
    //     'jumlahKK' => $jumlahKK,
    // ]);
    
    // }
    

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
