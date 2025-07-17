<?php

namespace App\Http\Controllers;

use App\Models\area_scope;
use App\Models\waste_bank;
use Illuminate\Http\Request;

class WasteBankReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $areaScope = area_scope::all();
        $status_deposit = $request->wtb_deposit_type;
        $query = waste_bank::with(['user', 'details.trashCategory'])
            ->when($request->filled('tanggal'), function ($q) use ($request) {
                $q->whereDate('created_at', $request->tanggal);
            })
            ->when($request->filled('rt'), function ($q) use ($request) {
                $q->whereHas('user', function ($query) use ($request) {
                    $query->where('usr_scope_id', $request->rt);
                });
            })
            ->latest();

        $wasteBanks = $query->get();

        return view('wastebank_officer.reports.index', compact('wasteBanks','areaScope', 'status_deposit'));
    }

    public function getData(Request $request)
{
    $query = waste_bank::with('user')
        ->when($request->filled('year'), fn($q) => $q->whereYear('created_at', $request->year))
        ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', $request->month))
        ->when($request->filled('usr_scope_id'), function ($q) use ($request) {
            $q->whereHas('user', fn($sub) => $sub->where('usr_scope_id', $request->usr_scope_id));
        })
        ->when($request->filled('wtb_deposit_type'), fn($q) => $q->where('wtb_deposit_type', $request->wtb_deposit_type))
        ->get();

    $data = $query->map(function ($item, $index) {
        return [
            'index' => $index + 1,
            'nama' => $item->user->name ?? '-',
            'jumlah' => 'Rp ' . number_format($item->wtb_total_money, 0, ',', '.'),
            'status' => ucfirst($item->wtb_deposit_type),
            'aksi' => '<button class="btn btn-sm btn-success btn-tandai-disahkan" data-id="'.$item->id.'">Tandai</button>'
        ];
    });

    return response()->json(['data' => $data]);
}

public function getTotal(Request $request)
{
    $total = waste_bank::when($request->filled('year'), fn($q) => $q->whereYear('created_at', $request->year))
        ->when($request->filled('month'), fn($q) => $q->whereMonth('created_at', $request->month))
        ->when($request->filled('usr_scope_id'), function ($q) use ($request) {
            $q->whereHas('user', fn($sub) => $sub->where('usr_scope_id', $request->usr_scope_id));
        })
        ->when($request->filled('pyn_status_submission'), fn($q) => $q->where('wtb_deposit_type', $request->pyn_status_submission))
        ->sum('wtb_total_money');

    return response()->json([
        'total' => $total,
        'total_format' => 'Rp ' . number_format($total, 0, ',', '.')
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
