<?php

namespace App\Http\Controllers;

use App\Models\area_scope;
use App\Models\payments;
use Illuminate\Http\Request;

class ConfirmmSubmission extends Controller
{

    public function index_treasurer(Request $request)
    {
        $year = $request->year ?? date('Y');
        $month = $request->month;
        $scopeId = $request->usr_scope_id;
        $status = $request->pyn_status_submission;

    // Query data pembayaran metode bank sampah milik user login
        $query = payments::whereYear('created_at', $year)
            ->where('metode_bayar', 'bank_sampah');

    if (!empty($month)) {
        $query->whereMonth('created_at', $month);
    }
    if (!empty($scopeId)) {
        $query->whereHas('user', function ($q) use ($scopeId) {
            $q->where('usr_scope_id', $scopeId);
        });
    }
    if ($request->filled('pyn_status_submission')) {
        $query->whereIn('pyn_status_submission', ['Menunggu Konfirmasi', 'Sudah Dikonfirmasi']);
    } 

    $payments = $query->get();
    $areaScope = area_scope::all();
    $total_uang = $payments->sum('jumlah_bayar');

    $title = 'Tandai Penyerahan!';
    $text = "Yakin ingin menandai pembayaran ini sebagai sudah diserahkan?";
    confirmDelete($title, $text);

    return view('treasurer.submission_fund.index', compact(
        'payments',
        'areaScope',
        'total_uang',
        'year',
        'month',
        'scopeId',
        'status'
    ));
    }

    public function getDataConfirm(Request $request)
    {
        $year = $request->year ?? date('Y');
        $month = $request->month ?? date('n');
    
        $query = payments::with(['user.areaScope'])
            ->where('metode_bayar', 'bank_sampah')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('pyn_status_submission', ['Menunggu Konfirmasi', 'Sudah Dikonfirmasi']);
    
        if ($request->filled('usr_scope_id')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('usr_scope_id', $request->usr_scope_id);
            });
        }
        if ($request->filled('pyn_status_submission')) {
            $query->where('pyn_status_submission', $request->pyn_status_submission);
        }
    
        $data = $query->get()->map(function ($p, $i) {
            return [
                'index' => $i + 1,
                'nama' => $p->user->name ?? '-',
                'jumlah' => 'Rp' . number_format($p->jumlah_bayar, 0, ',', '.'),
                'status' => match ($p->pyn_status_submission) {
                    'Menunggu Konfirmasi' => '<span class="badge bg-info">Menunggu Konfirmasi</span>',
                    'Sudah Dikonfirmasi' => '<span class="badge bg-success">Sudah Dikonfirmasi</span>',
                    default => '<span class="badge bg-secondary">Belum Diserahkan</span>',
                },
                'aksi' => $p->pyn_status_submission === 'Menunggu Konfirmasi'
                    ? '<button class="btn btn-sm btn-primary btn-konfirmasi" data-id="' . $p->pyn_id . '">Konfirmasi</button>'
                    : '<span class="badge bg-success">Sudah Dikonfirmasi</span>'
            ];
        });
        
        return response()->json(['data' => $data]);
    }
 

    public function confirm($id)
{
        $payment = payments::findOrFail($id);
    
        if ($payment->metode_bayar === 'bank_sampah' && $payment->pyn_status_submission === 'Menunggu Konfirmasi') {
            $payment->pyn_status_submission = 'Sudah Dikonfirmasi';
            $payment->save();
    
            return response()->json([
                'message' => 'Penyerahan dana berhasil dikonfirmasi.'
            ]);
        }
    
        return response()->json([
            'message' => 'Data tidak valid atau sudah dikonfirmasi.',
        ], 400); // kasih status error 400
    }
    public function getTotal(Request $request)
{
    \Log::debug('Request Params:', $request->all());

    $query = payments::query()
        ->where('metode_bayar', 'bank_sampah');

    if ($request->filled('pyn_status_submission')) {
        $query->where('pyn_status_submission', $request->pyn_status_submission);
    } else {
        $query->where('pyn_status_submission', 'Sudah Dikonfirmasi');
    }

    if ($request->filled('year')) {
        $query->whereYear('created_at', $request->year);
    }

    if ($request->filled('month')) {
        $query->whereMonth('created_at', $request->month);
    }

    if (!empty($request->usr_scope_id)) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('usr_scope_id', $request->usr_scope_id);
        });
    }

    $total = $query->sum('jumlah_bayar');

    return response()->json([
        'total' => $total,
        'total_format' => 'Rp' . number_format($total, 0, ',', '.')
    ]);
}

    
    







    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
