<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\waste_bank;
use App\Models\waste_bank_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WasteBankDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data berat sampah per bulan
    $dataPerBulan = DB::table('waste_bank_details')
    ->join('waste_banks', 'waste_banks.id', '=', 'waste_bank_details.waste_bank_id')
    ->whereNull('waste_banks.deleted_at')
    ->whereYear('waste_banks.created_at', date('Y')) // Tahun sekarang saja
    ->selectRaw('MONTH(waste_banks.created_at) as bulan_angka, DATE_FORMAT(waste_banks.created_at, "%M") as bulan_label, SUM(waste_bank_details.berat) as total_berat')
    ->groupByRaw('MONTH(waste_banks.created_at), DATE_FORMAT(waste_banks.created_at, "%M")')
    ->orderByRaw('MONTH(waste_banks.created_at)')
    ->get();

// Data untuk grafik
$labels = $dataPerBulan->pluck('bulan_label');
$values = $dataPerBulan->pluck('total_berat');

return view('wastebank_officer.dashboard.index', [
    'bulanLabels'      => $labels,
    'beratPerBulan'    => $values,

    // Saldo dari tabungan
    'totalUang'        => \App\Models\waste_bank::where('wtb_deposit_type', 'tabung')->sum('wtb_total_money'),

    // Berat total semua kategori
    'totalBerat'       => \App\Models\waste_bank_details::sum('berat'),

    // Jumlah warga unik yang menabung
    'jumlahPenabung'   => \App\Models\waste_bank::distinct('wtb_name_id')->count(),

    // Total uang yang langsung diambil
    'danaDiambil'      => \App\Models\waste_bank::where('wtb_deposit_type', 'tunai')->sum('wtb_total_money'),

    // Jumlah laporan penyerahan dana → pakai tabel `payments`
    'laporanMasuk'     => \App\Models\payments::where('metode_bayar', 'bank_sampah')->count(),
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
