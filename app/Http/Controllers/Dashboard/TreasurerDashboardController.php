<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\payment_category;
use App\Models\payments;
use App\Models\waste_bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreasurerDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $kategoriAir = payment_category::where('pym_name', 'Retribusi Air')->first();


        $totalPemasukanAir = 0;
        if ($kategoriAir) {
            $totalPemasukanAir = payments::where('pyn_payment_category_id', $kategoriAir->pym_id)
                ->where('status', 'lunas')  // opsional: hanya yang lunas
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('jumlah_bayar');
        }
    
        // Total pemasukan (kategori tidak null)
        $totalPemasukan = payments::whereNotNull('pyn_payment_category_id')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('jumlah_bayar');

        // Total pengeluaran (kategori null dan ada catatan)
        $totalPengeluaran = payments::whereNull('pyn_payment_category_id')
            ->whereNotNull('pyn_sys_note')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('jumlah_bayar');

            
           
        // Potongan bendahara 10%
        $potonganBendahara = $totalPemasukanAir * 0.1;
        // Saldo akhir
        $saldoAkhir = $totalPemasukan - $totalPengeluaran - $potonganBendahara;

        // Data grafik pemasukan & pengeluaran bulanan
        $dataBulanan = payments::selectRaw('MONTH(created_at) as bulan, 
            SUM(CASE WHEN pyn_payment_category_id IS NOT NULL THEN jumlah_bayar ELSE 0 END) as total_masuk,
            SUM(CASE WHEN pyn_payment_category_id IS NULL AND pyn_sys_note IS NOT NULL THEN jumlah_bayar ELSE 0 END) as total_keluar')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulanLabels = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

        $pemasukanBulanan = array_fill(0, 12, 0);
        $pengeluaranBulanan = array_fill(0, 12, 0);

        foreach ($dataBulanan as $row) {
            $index = $row->bulan - 1;
            $pemasukanBulanan[$index] = $row->total_masuk;
            $pengeluaranBulanan[$index] = $row->total_keluar;
        }

        // Transaksi terbaru
        $transaksiMasuk = payments::whereNotNull('pyn_payment_category_id')
            ->latest()->limit(5)->get();

        $transaksiKeluar = payments::whereNull('pyn_payment_category_id')
            ->whereNotNull('pyn_sys_note')
            ->latest()->limit(5)->get();

        return view('treasurer.dashboard', compact(
            'totalPemasukan', 'totalPengeluaran', 'potonganBendahara', 'saldoAkhir',
            'bulanLabels', 'pemasukanBulanan', 'pengeluaranBulanan',
            'transaksiMasuk', 'transaksiKeluar'
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
