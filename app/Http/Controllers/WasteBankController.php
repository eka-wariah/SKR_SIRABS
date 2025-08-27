<?php

namespace App\Http\Controllers;

use App\Models\trash_category;
use App\Models\User;
use App\Models\waste_bank;
use App\Models\waste_bank_details;
use Illuminate\Http\Request;

class WasteBankController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');
        $month = $request->month;

        $query = waste_bank::whereYear('created_at', $year);
        if (!empty($month)) {
            $query->whereMonth('created_at', $month);
        }

        $waste_bank = $query->get();
        $users = User::all();
        $trash_category = trash_category::all();
        $total_uang = $waste_bank->sum('wtb_total_money');

        return view('wastebank_officer.waste_bank.index', compact(['waste_bank', 'users', 'trash_category', 'total_uang', 'year', 'month']));
    }

    public function create()
    {
        $users = User::all();
        $trash_category = trash_category::all();
        return view('wastebank_officer.waste_bank.create', compact(['users', 'trash_category']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usr_id' => 'required|exists:users,usr_id',
            'categories' => 'required|array|min:1',
            'categories.*.trc_id' => 'required|exists:trash_categories,trc_id',
            'categories.*.berat' => 'required|numeric|min:0.1',
            'deposit_type' => 'required|in:tabung,tunai',
        ]);

        $waste_bank = new waste_bank();
        $waste_bank->wtb_name_id = $request->usr_id;
        $waste_bank->wtb_total_money = 0;
        $waste_bank->wtb_deposit_type = $request->deposit_type;
        $waste_bank->save();

        $total = 0;
        foreach ($request->categories as $item) {
            $trash_category = trash_category::find($item['trc_id']);
            $sub = $item['berat'] * $trash_category->trc_price;
            $total += $sub;

            waste_bank_details::create([
                'waste_bank_id' => $waste_bank->id,
                'trc_id' => $item['trc_id'],
                'berat' => $item['berat'],
                'total' => $sub,
            ]);
        }

        $waste_bank->update(['wtb_total_money' => $total]);

        if ($request->deposit_type === 'tabung') {
            $user = User::where('usr_id', $request->usr_id)->first();
            $user->total_money = waste_bank::where('wtb_name_id', $user->usr_id)
                ->where('wtb_deposit_type', 'tabung')
                ->sum('wtb_total_money');
            $user->save();
        }

        return redirect('wastebank_officer/waste_bank');
    }

    public function show($id)
    {
        $waste_bank = waste_bank::with('details.trashCategory')->findOrFail($id);
        return view('wastebank_officer.waste_bank.show', compact('waste_bank'));
    }

    public function edit($id)
{
    $waste_bank = waste_bank::with('details')->findOrFail($id);
    $users = User::all();
    $trash_category = trash_category::all();

    return view('wastebank_officer.waste_bank.edit', compact('waste_bank', 'users', 'trash_category'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'usr_id' => 'required|exists:users,usr_id',
        'categories' => 'required|array|min:1',
        'categories.*.trc_id' => 'required|exists:trash_categories,trc_id',
        'categories.*.berat' => 'required|numeric|min:0.1',
        'deposit_type' => 'required|in:tabung,tunai',
    ]);

    $waste_bank = waste_bank::findOrFail($id);
    $waste_bank->wtb_name_id = $request->usr_id;
    $waste_bank->wtb_deposit_type = $request->deposit_type;
    $waste_bank->save();

    // Hapus data lama
    $waste_bank->details()->delete();

    $total = 0;
    foreach ($request->categories as $item) {
        $trash_category = trash_category::find($item['trc_id']);
        $sub = $item['berat'] * $trash_category->trc_price;
        $total += $sub;

        waste_bank_details::create([
            'waste_bank_id' => $waste_bank->id,
            'trc_id' => $item['trc_id'],
            'berat' => $item['berat'],
            'total' => $sub,
        ]);
    }

    $waste_bank->wtb_total_money = $total;
    $waste_bank->save();

    return redirect()->route('waste_bank.index')->with('success', 'Data berhasil diperbarui.');
}

    public function destroy($id)
    {
        $waste_bank = waste_bank::findOrFail($id);
        $userId = $waste_bank->wtb_name_id;
        $waste_bank->delete();

        $user = User::where('usr_id', $userId)->first();
        $user->total_money = waste_bank::where('wtb_name_id', $userId)
            ->where('wtb_deposit_type', 'tabung')
            ->sum('wtb_total_money');
        $user->save();

        return redirect('wastebank_officer/waste_bank');
    }
}
