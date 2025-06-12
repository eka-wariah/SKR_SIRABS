<?php

namespace App\Http\Controllers;

use App\Models\area_scope;
use App\Models\payments;
use App\Models\submission_fund;
use Illuminate\Http\Request;

class SubmissionFundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_officer(Request $request)
    {
        $year = $request->year ?? date('Y');
        $month = $request->month;
        $scopeId = $request->usr_scope_id;
        $status = $request->pyn_status_submission;

    // Query data pembayaran metode bank sampah milik user login
        $query = payments::whereYear('pyn_created_at', $year)
            ->where('metode_bayar', 'bank_sampah');

    if (!empty($month)) {
        $query->whereMonth('pyn_created_at', $month);
    }
    if (!empty($scopeId)) {
        $query->whereHas('user', function ($q) use ($scopeId) {
            $q->where('usr_scope_id', $scopeId);
        });
    }
    if (!empty($status)) {
        $query->where('pyn_status_submission', $status);
    }

    $payments = $query->get();
    $areaScope = area_scope::all();
    $total_uang = $payments->sum('jumlah_bayar');

    $title = 'Tandai Penyerahan!';
    $text = "Yakin ingin menandai pembayaran ini sebagai sudah diserahkan?";
    confirmDelete($title, $text);

    return view('wastebank_officer.submission_fund.index', compact(
        'payments',
        'areaScope',
        'total_uang',
        'year',
        'month',
        'scopeId',
        'status'
    ));

    }

    public function getData(Request $request)
{
    $year = $request->year ?? date('Y');
    $month = $request->month ?? date('n');

    $query = payments::with(['user.areaScope'])
        ->where('metode_bayar', 'bank_sampah')
        ->whereYear('pyn_created_at', $year)
        ->whereMonth('pyn_created_at', $month);

    if ($request->filled('usr_scope_id')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('usr_scope_id', $request->usr_scope_id);
        });
    }
    if ($request->filled('pyn_status_submission')) {

        $query->whereHas('user', function ($q) use ($request) {
            $q->where('pyn_status_submission', $request->pyn_status_submission);
        });
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
            'aksi' => $p->pyn_status_submission === 'Belum Diserahkan'
                ? '<form method="POST" action="' . route('submission.mark_submitted', $p->pyn_id) . '">' .
                  csrf_field() .
                  '<button type="submit" class="btn btn-sm btn-primary">Tandai Sudah Diserahkan</button>' .
                  '</form>'
                : '<span class="badge bg-success">Sudah Dikonfirmasi</span>'
        ];
    });

    return response()->json(['data' => $data]);
}


    public function mark_submitted($id)
    {
    $payment = payments::findOrFail($id);

    // hanya update jika metode bank sampah
    if ($payment->metode_bayar === 'bank_sampah') {
        $payment->pyn_status_submission = 'Menunggu Konfirmasi';
        $payment->save();
    }

    return back()->with('success', 'Penyerahan dana ditandai sebagai Menunggu Konfirmasi.');
    }


    public function index_treasurer()
    {
    $payments = payments::where('metode_bayar', 'bank_sampah')
        ->get();

    return view('treasurer.submission_fund.index', compact('payments'));
    }

    public function confirm_submission($id)
{
    $payment = payments::findOrFail($id);

    // Pastikan hanya transaksi dengan metode bank_sampah yang bisa dikonfirmasi
    if ($payment->metode_bayar === 'bank_sampah' && $payment->pyn_status_submission === 'Menunggu Konfirmasi') {
        $payment->pyn_status_submission = 'Sudah Dikonfirmasi';
        $payment->pyn_treasurer_id = auth()->user()->usr_id; // simpan siapa yang konfirmasi
        $payment->save();
    }

    return back()->with('success', 'Dana berhasil dikonfirmasi.');
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
    public function show(submission_fund $submission_fund)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(submission_fund $submission_fund)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, submission_fund $submission_fund)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(submission_fund $submission_fund)
    {
        //
    }
}
