<?php

namespace App\Http\Controllers;

use App\Models\payment_category;
use App\Models\payments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RTReportRetribution extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getSummaryData($request);
        return view('rt_leader.report_retribution.index', $data);
    }
    
    public function summaryPartial(Request $request)
    {
        $data = $this->getSummaryData($request);
        return view('rt_leader.report_retribution.summary', $data);
    }
    
    private function getSummaryData(Request $request)
    {
        $rt = Auth::user();
        $year = $request->year ?? now()->year;
        $month = $request->month ?? now()->month;
    
        $pemasukan = payments::with(['user', 'paymentCategory'])
            ->whereNotNull('pyn_payment_category_id')
            ->whereHas('user', fn($q) => $q->where('usr_scope_id', $rt->usr_scope_id))
            ->where('status', 'lunas')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();
    
        $pengeluaran = payments::with('user')
            ->whereNull('pyn_payment_category_id')
            ->where('status', 'lunas')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();
    
        $payments = $pemasukan->merge($pengeluaran)->map(function ($item) {
            $item->tipe = $item->pyn_payment_category_id ? 'Pemasukan' : 'Pengeluaran';
            $item->kategori = $item->pyn_payment_category_id
                ? (stripos($item->paymentCategory->pym_name ?? '', 'air') !== false ? 'Air'
                    : (stripos($item->paymentCategory->pym_name ?? '', 'sampah') !== false ? 'Sampah' : 'Lainnya'))
                : strtolower($item->pyn_sys_kategori ?? 'Tidak Diketahui');
            return $item;
        });
    
        $airTotal = $payments->where('tipe', 'Pemasukan')->where('kategori', 'Air')->sum('jumlah_bayar');
        $airPotongan = $airTotal * 0.10;
        $airPengeluaran = $payments->where('tipe', 'Pengeluaran')->where('kategori', 'air')->sum('jumlah_bayar');
    
        $sampahTotal = $payments->where('tipe', 'Pemasukan')->where('kategori', 'Sampah')->sum('jumlah_bayar');
        $sampahPengeluaran = $payments->where('tipe', 'Pengeluaran')->where('kategori', 'sampah')->sum('jumlah_bayar');
    
        $totalPemasukan = ($airTotal - $airPotongan) + $sampahTotal;
        $totalPengeluaran = $airPengeluaran + $sampahPengeluaran;
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;
    
        return compact(
            'year', 'month',
            'airTotal', 'airPotongan', 'airPengeluaran',
            'sampahTotal', 'sampahPengeluaran',
            'totalPemasukan', 'totalPengeluaran', 'saldoAkhir'
        );
    }
    


    public function detail(Request $request)
    {
        $type = $request->type;
        $year = $request->year ?? now()->year;
        $month = $request->month ?? now()->month;
    
        $rt = Auth::user();
    
        $query = payments::with(['user', 'paymentCategory'])
    ->where('status', 'lunas')
    ->whereYear('created_at', $year)
    ->whereMonth('created_at', $month);

if (in_array($type, ['air', 'sampah'])) {
    $query->whereHas('user', fn($q) => $q->where('usr_scope_id', $rt->usr_scope_id));
}

switch ($type) {
    case 'air':
        $query->whereHas('paymentCategory', fn($q) => $q->where('pym_name', 'like', '%air%'));
        break;
    case 'sampah':
        $query->whereHas('paymentCategory', fn($q) => $q->where('pym_name', 'like', '%sampah%'));
        break;
    case 'keluar_air':
        $query->whereNull('pyn_payment_category_id')
            ->where('pyn_sys_kategori', 'air');
        break;
    case 'keluar_sampah':
        $query->whereNull('pyn_payment_category_id')
            ->where('pyn_sys_kategori', 'sampah');
        break;
    default:
        return response()->json(['html' => 'Tipe tidak dikenali'], 400);
}

    
        $data = $query->get();
    
        if ($data->isEmpty()) {
            return response()->json(['html' => 'Tidak ada data'], 404);
        }
    
        $html = view('rt_leader.report_retribution.modal', compact('data', 'type'))->render();
    
        return response()->json(['html' => $html]);
    }
    
    public function ajaxData(Request $request)
{
    $year = $request->year ?? now()->year;
    $month = $request->month ?? now()->month;
    $rt = Auth::user();

    // Ambil semua pembayaran warga RT terkait
    $pemasukan = payments::with('paymentCategory')
        ->whereNotNull('pyn_payment_category_id')
        ->whereHas('user', fn($q) => $q->where('usr_scope_id', $rt->usr_scope_id))
        ->where('status', 'lunas')
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->get();

    $pengeluaran = payments::whereNull('pyn_payment_category_id')
        ->where('status', 'lunas')
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->get();

    $data = [];
    $totalMasuk = 0;
    $totalKeluar = 0;

    foreach ($pemasukan as $item) {
        $kategori = $item->paymentCategory->pym_name ?? 'Lainnya';
        $data[] = [
            'tanggal' => $item->created_at->format('d-m-Y'),
            'keterangan' => $kategori,
            'pemasukan' => 'Rp' . number_format($item->jumlah_bayar, 0, ',', '.'),
            'pengeluaran' => '',
        ];
        $totalMasuk += $item->jumlah_bayar;
    }

    foreach ($pengeluaran as $item) {
        $kategori = ucfirst($item->pyn_sys_kategori ?? 'Lainnya');
        $data[] = [
            'tanggal' => $item->created_at->format('d-m-Y'),
            'keterangan' => $kategori,
            'pemasukan' => '',
            'pengeluaran' => 'Rp' . number_format($item->jumlah_bayar, 0, ',', '.'),
        ];
        $totalKeluar += $item->jumlah_bayar;
    }

    return response()->json([
        'data' => $data,
        'total_masuk' => $totalMasuk,
        'total_keluar' => $totalKeluar,
        'saldo_akhir' => $totalMasuk - $totalKeluar,
    ]);
}


}
