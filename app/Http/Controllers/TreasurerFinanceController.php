<?php

namespace App\Http\Controllers;

use App\Models\payment_category;
use App\Models\payments;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreasurerFinanceController extends Controller
{
    public function index()
{
    $selectedYear = request('year', date('Y'));
    $selectedMonth = request('month', date('n'));

    $user = Auth::user();
    $warga = User::role('citizen')->with('household')->get();
    $households = User::where('usr_scope_id', $user->usr_scope_id)
        ->pluck('household_id')->unique();

    $paymentCategories = payment_category::all();

    $payments = payments::with('paymentCategory')
        ->where('pyn_treasurer_id', $user->usr_id)
        ->where('status', 'lunas')
        ->whereYear('created_at', $selectedYear)
        ->whereMonth('created_at', $selectedMonth)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($item) {
            $item->tipe = $item->pyn_payment_category_id ? 'Pemasukan' : 'Pengeluaran';
            if ($item->pyn_payment_category_id) {
                $item->kategori = stripos($item->paymentCategory->pym_name ?? '', 'air') !== false
                    ? 'Air'
                    : (stripos($item->paymentCategory->pym_name ?? '', 'sampah') !== false ? 'Sampah' : 'Lainnya');
            } else {
                $item->kategori = ucfirst($item->pyn_sys_kategori ?? 'Tidak Diketahui');
            }
            return $item;
        });

    $pemasukanAir = $payments->where('tipe', 'Pemasukan')->where('kategori', 'Air');
    $pengeluaranAir = $payments->where('tipe', 'Pengeluaran')->where('kategori', 'Air');

    $pemasukanSampah = $payments->where('tipe', 'Pemasukan')->where('kategori', 'Sampah');
    $pengeluaranSampah = $payments->where('tipe', 'Pengeluaran')->where('kategori', 'Sampah');

    $airTotal = $pemasukanAir->sum('jumlah_bayar');
    $airPotongan = $airTotal * 0.10;
    $airPengeluaran = $pengeluaranAir->sum('jumlah_bayar');
    $airSaldo = $airTotal - $airPotongan - $airPengeluaran;

    $sampahTotal = $pemasukanSampah->sum('jumlah_bayar');
    $sampahPengeluaran = $pengeluaranSampah->sum('jumlah_bayar');
    $sampahSaldo = $sampahTotal - $sampahPengeluaran;

    return view('treasurer.finance.index', compact(
        'payments', 'households', 'paymentCategories',
        'airTotal', 'airPotongan', 'airPengeluaran', 'airSaldo',
        'sampahTotal', 'sampahPengeluaran', 'sampahSaldo', 'warga',
        'selectedYear', 'selectedMonth' // ✅ Tambahkan ke view
    ));
}


    public function createPayment()
    {
        $warga = User::role('citizen')->get();
        $paymentCategories = payment_category::all();
        return view('treasurer.finance.create', compact('warga', 'paymentCategories'));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,usr_id',
            'pyn_payment_category_id' => 'required',
        ]);
    
        $user = User::where('usr_id', $request->user_id)->firstOrFail();
        $periode = now()->format('Y-m');
        if ($request->pyn_payment_category_id === 'combined') {
            $air = payment_category::where('pym_name', 'like', '%Air%')->first();
            $sampah = payment_category::where('pym_name', 'like', '%Sampah%')->first();
    
            if ($air) {
                payments::create([
                    'pyn_paid_by' => $user->usr_id,
                    'pyn_treasurer_id' => Auth::user()->usr_id, 
                    'pyn_household_id' => $user->household_id,
                    'pyn_payment_category_id' => $air->pym_id,
                    'jumlah_bayar' => $air->pym_total,
                    'metode_bayar' => 'internal',
                    'status' => 'Lunas',
                    'pyn_status_submission' => 'Sudah Dikonfirmasi',
                    'pyn_sys_note' => 'Gabungan Air & Sampah',
                    'pyn_periode' => now()->format('Y-m'),
                ]);
            }
    
            if ($sampah) {
                payments::create([
                    'pyn_paid_by' => $user->usr_id,
                    'pyn_treasurer_id' => Auth::user()->usr_id, 
                    'pyn_household_id' => $user->household_id,
                    'pyn_payment_category_id' => $sampah->pym_id,
                    'jumlah_bayar' => $sampah->pym_total,
                    'metode_bayar' => 'internal',
                    'status' => 'Lunas',
                    'pyn_status_submission' => 'Sudah Dikonfirmasi',
                    'pyn_sys_note' => 'Gabungan Air & Sampah',
                    'pyn_periode' => now()->format('Y-m'),
                ]);
            }
        } else {
            $kategori = payment_category::findOrFail($request->pyn_payment_category_id);
            payments::create([
                'pyn_paid_by' => $user->usr_id,
                'pyn_treasurer_id' => Auth::user()->usr_id, 
                'pyn_household_id' => $user->household_id,
                'pyn_payment_category_id' => $kategori->pym_id,
                'jumlah_bayar' => $kategori->pym_total,
                'metode_bayar' => 'internal',
                'status' => 'Lunas',
                'pyn_status_submission' => 'Sudah Dikonfirmasi',
                'pyn_periode' => now()->format('Y-m'),
            ]);
        }
    
        return redirect()->route('treasurer.finance.index')->with('success', 'Pembayaran berhasil dicatat.');
    }
    

    public function storeExpense(Request $request)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric',
            'keterangan' => 'required|in:air,sampah',
        ]);

        payments::create([
            'pyn_household_id' => Auth::user()->usr_scope_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'pyn_treasurer_id' => Auth::user()->usr_id,
            'pyn_payment_category_id' => null,
            'metode_bayar' => 'internal',
            'status' => 'lunas',
            'pyn_periode' => now()->format('Y-m'),
            'pyn_sys_kategori' => $request->keterangan,
            'pyn_sys_note' => $request->deskripsi,
        ]);

        return back()->with('success', 'Pengeluaran berhasil ditambahkan.');
    }
    public function downloadCashflow(Request $request)
    {
        $tahun = $request->get('year', date('Y'));
    $bulan = $request->get('month', date('n'));

    $loggedUser = Auth::user();
    $namaBendahara = Auth::user()->usr_name ?? Auth::user()->name;
    $nomorRT = $loggedUser->areaScope->scope_name ?? 'RT Tidak Diketahui';

    $payments = payments::with('paymentCategory')
        ->where('pyn_treasurer_id', $loggedUser->usr_id)
        ->whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->where('status', 'lunas')
        ->get()
        ->map(function ($item) {
            $item->tipe = $item->pyn_payment_category_id ? 'Pemasukan' : 'Pengeluaran';
            if ($item->pyn_payment_category_id) {
                $item->kategori = stripos($item->paymentCategory->pym_name ?? '', 'air') !== false
                    ? 'Air'
                    : (stripos($item->paymentCategory->pym_name ?? '', 'sampah') !== false ? 'Sampah' : 'Lainnya');
            } else {
                $item->kategori = ucfirst($item->pyn_sys_kategori ?? 'Tidak Diketahui');
            }
            return $item;
        });

    $pemasukanAir = $payments->where('tipe', 'Pemasukan')->where('kategori', 'Air');
    $pemasukanSampah = $payments->where('tipe', 'Pemasukan')->where('kategori', 'Sampah');
    $pengeluaranAir = $payments->where('tipe', 'Pengeluaran')->where('kategori', 'Air');
    $pengeluaranSampah = $payments->where('tipe', 'Pengeluaran')->where('kategori', 'Sampah');

    $airTotal = $pemasukanAir->sum('jumlah_bayar');
    $airPotongan = $airTotal * 0.10;
    $airBersih = $airTotal - $airPotongan;

    $sampahTotal = $pemasukanSampah->sum('jumlah_bayar');
    $totalPemasukan = $airBersih + $sampahTotal;

    $totalPengeluaran = $pengeluaranAir->sum('jumlah_bayar') + $pengeluaranSampah->sum('jumlah_bayar');
    $saldoAkhir = $totalPemasukan - $totalPengeluaran;

    $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F');

    $data = [
        'bulan' => $namaBulan,
        'tahun' => $tahun,
        'airTotal' => $airTotal,
        'airPotongan' => $airPotongan,
        'airBersih' => $airBersih,
        'sampahTotal' => $sampahTotal,
        'totalPemasukan' => $totalPemasukan,
        'pengeluaranAir' => $pengeluaranAir->sum('jumlah_bayar'),
        'pengeluaranSampah' => $pengeluaranSampah->sum('jumlah_bayar'),
        'totalPengeluaran' => $totalPengeluaran,
        'saldoAkhir' => $saldoAkhir,
        'namaBendahara' => $namaBendahara,
        'nomorRT' => $nomorRT,
    ];

    $pdf = Pdf::loadView('treasurer.finance.laporan-arus-kas', $data)->setPaper('a4');
    return $pdf->download(" LAPORAN PEMBAYARAN RETRIBUSI {$namaBulan} {$tahun} - {$nomorRT}.pdf");
    }

    public function getFinanceData(Request $request)
{
    $user = Auth::user();
    $year = $request->input('year', date('Y'));
    $month = $request->input('month', date('n'));

    $payments = payments::with('paymentCategory')
        ->where('pyn_treasurer_id', $user->usr_id)
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->where('status', 'lunas')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($item) {
            $item->tipe = $item->pyn_payment_category_id ? 'Pemasukan' : 'Pengeluaran';
            $item->kategori = $item->pyn_payment_category_id
                ? (stripos($item->paymentCategory->pym_name ?? '', 'air') !== false ? 'Air' : (stripos($item->paymentCategory->pym_name ?? '', 'sampah') !== false ? 'Sampah' : 'Lainnya'))
                : ucfirst($item->pyn_sys_kategori ?? 'Tidak Diketahui');
            return [
                'tanggal' => $item->created_at->format('d M Y'),
                'keterangan' => $item->tipe === 'Pemasukan'
                    ? 'Pembayaran ' . ($item->paymentCategory->pym_name ?? '-')
                    : 'Pengeluaran untuk ' . $item->kategori . ($item->pyn_sys_note ? ' - ' . $item->pyn_sys_note : ''),
                'pemasukan' => $item->tipe === 'Pemasukan' ? 'Rp' . number_format($item->jumlah_bayar, 0, ',', '.') : '',
                'pengeluaran' => $item->tipe === 'Pengeluaran' ? 'Rp' . number_format($item->jumlah_bayar, 0, ',', '.') : '',
            ];
        });

    return response()->json(['data' => array_values($payments->toArray())]);
}

public function updateExpense(Request $request, $id)
{
    $request->validate([
        'deskripsi' => 'required|string',
        'jumlah_bayar' => 'required|numeric',
        'keterangan' => 'required|in:air,sampah',
    ]);

    $payment = payments::findOrFail($id);
    if ($payment->pyn_payment_category_id !== null) {
        return back()->with('error', 'Hanya pengeluaran yang bisa diedit.');
    }

    $payment->update([
        'pyn_sys_note' => $request->deskripsi,
        'jumlah_bayar' => $request->jumlah_bayar,
        'pyn_sys_kategori' => $request->keterangan,
    ]);

    return redirect()->back()->with('success', 'Pengeluaran berhasil diperbarui.');
}

public function data(Request $request)
{
    $user = Auth::user();
    $year = $request->year ?? now()->year;
    $month = $request->month ?? now()->month;

    $payments = payments::with('paymentCategory')
        ->where('pyn_treasurer_id', $user->usr_id)
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->where('status', 'lunas')
        ->get()
        ->map(function ($item) {
            $item->tipe = $item->pyn_payment_category_id ? 'Pemasukan' : 'Pengeluaran';
            $item->kategori = $item->pyn_payment_category_id
                ? (stripos($item->paymentCategory->pym_name ?? '', 'air') !== false
                    ? 'air'
                    : (stripos($item->paymentCategory->pym_name ?? '', 'sampah') !== false ? 'sampah' : 'lainnya'))
                : strtolower($item->pyn_sys_kategori ?? '-');
            return $item;
        });

    // Total pemasukan air (kategori 'air')
    $totalPemasukanAir = $payments->where('tipe', 'Pemasukan')->where('kategori', 'air')->sum('jumlah_bayar');
    // Potongan bendahara 10% dari total pemasukan air
    $potonganBendahara = $totalPemasukanAir * 0.10;

    // Total pemasukan (semua kategori pemasukan)
    $totalPemasukan = $payments->where('tipe', 'Pemasukan')->sum('jumlah_bayar');

    // Total pengeluaran
    $totalPengeluaran = $payments->where('tipe', 'Pengeluaran')->sum('jumlah_bayar');

    // Saldo akhir setelah dipotong bendahara dan pengeluaran
    $saldoAkhir = $totalPemasukan - $potonganBendahara - $totalPengeluaran;

    $data = [];
    foreach ($payments as $item) {
        $data[] = [
            'id' => $item->pyn_id,
            'tanggal' => $item->created_at->format('d M Y'),
            'keterangan' => $item->tipe === 'Pemasukan'
                ? 'Pembayaran ' . ($item->paymentCategory->pym_name ?? '-')
                : 'Pengeluaran untuk ' . ucfirst($item->kategori) . ' - ' . $item->pyn_sys_note,
            'pemasukan' => $item->tipe === 'Pemasukan' ? 'Rp' . number_format($item->jumlah_bayar, 0, ',', '.') : '',
            'pengeluaran' => $item->tipe === 'Pengeluaran' ? 'Rp' . number_format($item->jumlah_bayar, 0, ',', '.') : '',
            'raw_jumlah' => $item->jumlah_bayar,
            'kategori' => $item->kategori,
        ];
    }


    $data[] = [
        'id' => 'potongan_bendahara',
        'tanggal' => '-',
        'keterangan' => 'Potongan Bendahara 10% dari total Air',
        'pemasukan' => '',
        'pengeluaran' => 'Rp' . number_format($potonganBendahara, 0, ',', '.'),
        'raw_jumlah' => $potonganBendahara,
        'kategori' => 'potongan',
    ];

    
    $totalPemasukan = $payments->where('tipe', 'Pemasukan')->sum('jumlah_bayar');
    $totalPengeluaran = $payments->where('tipe', 'Pengeluaran')->sum('jumlah_bayar') + $potonganBendahara;

    $saldoAkhir = $totalPemasukan - $totalPengeluaran;

    return response()->json([
        'data' => $data,
        'total_masuk' => $totalPemasukan,
        'total_keluar' => $totalPengeluaran,
        'saldo_akhir' => $saldoAkhir,
    ]);
}



}
