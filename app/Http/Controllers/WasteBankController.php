<?php

namespace App\Http\Controllers;

use App\Models\trash_category;
use App\Models\User;
use App\Models\waste_bank;
use App\Models\waste_bank_details;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class WasteBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
    
        return view('wastebank_officer.waste_bank.index', compact(['waste_bank', 'users', 'trash_category', 'total_uang', 'year', 'month']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $trash_category = trash_category::all();
        return view('wastebank_officer.waste_bank.create',  compact([ 'users', 'trash_category']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usr_id' => 'required|exists:users,usr_id',
            'categories' => 'required|array|min:1',
            'categories.*.trc_id' => 'required|exists:trash_categories,trc_id',
            'categories.*.berat' => 'required|numeric|min:0.1',
        ]);
    
        // Buat dan simpan waste bank utama
        $waste_bank = new waste_bank();
        $waste_bank->wtb_name_id = $request->usr_id;
        $waste_bank->wtb_total_money = 0; // sementara
        $waste_bank->save(); // ✅ PENTING agar ada ID
    
        $total = 0;
    
        // Simpan detail satu per satu
        foreach ($request->categories as $item) {
            $trash_category = trash_category::find($item['trc_id']);
            $sub = $item['berat'] * $trash_category->trc_price;
            $total += $sub;
    
            $detail = new waste_bank_details();
$detail->waste_bank_id = $waste_bank->id;
$detail->trc_id = $item['trc_id'];
$detail->berat = $item['berat'];
$detail->total = $sub;
$detail->save();
        }
    
        // Update total uang
        $waste_bank->update(['wtb_total_money' => $total]);
    
        // Tambah ke saldo user
        $user = User::where('usr_id', $request->usr_id)->first();
        $user->total_money += $total;
        $user->save();
    
        return redirect('wastebank_officer/waste_bank');
    }

    /**
     * Display the specified resource.
     */
    public function show(waste_bank $waste_bank, $id)
    {
        $waste_bank = waste_bank::with('details.trashCategory')->findOrFail($id);

    return view('wastebank_officer.waste_bank.show', compact('waste_bank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(waste_bank $waste_bank, $id)
    {
        $users = User::all();
        $trash_category = trash_category::all();
        $detail = waste_bank_details::all();
        $EditWasteBank = waste_bank::with('details')->findOrFail($id);
        return view('wastebank_officer.waste_bank.edit', compact(['EditWasteBank', 'users', 'trash_category','detail']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, waste_bank $waste_bank, $id)
    {
        $request->validate([
            'usr_id' => 'required|exists:users,usr_id',
            'categories' => 'required|array|min:1',
            'categories.*.trc_id' => 'required|exists:trash_categories,trc_id',
            'categories.*.berat' => 'required|numeric|min:0.1',
        ]);
    
        $waste_bank = waste_bank::findOrFail($id);
    
        // Ambil total lama untuk rollback saldo user
        $old_total = $waste_bank->wtb_total_money;
    
        // Kurangi saldo lama dari user lama
        $old_user = User::where('usr_id', $waste_bank->wtb_name_id)->first();
        $old_user->total_money -= $old_total;
        $old_user->save();
    
        // Update data utama
        $waste_bank->wtb_name_id = $request->usr_id;
        $waste_bank->wtb_total_money = 0;
        $waste_bank->save();
    
        // Hapus detail lama
        waste_bank_details::where('waste_bank_id', $waste_bank->id)->delete();
    
        // Simpan ulang detail baru
        $total = 0;
        foreach ($request->categories as $i => $item) {
            $category = trash_category::find($item['trc_id']);
            $subtotal = $item['berat'] * $category->trc_price;
            $total += $subtotal;
    
            waste_bank_details::create([
                'waste_bank_id' => $waste_bank->id,
                'trc_id' => $item['trc_id'],
                'berat' => $item['berat'],
                'total' => $subtotal,
            ]);
        }
    
        // Update total uang di bank sampah
        $waste_bank->update(['wtb_total_money' => $total]);
    
        // Tambahkan saldo baru ke user
        $new_user = User::where('usr_id', $request->usr_id)->first();
        $new_user->total_money += $total;
        $new_user->save();
    
        return redirect()->route('waste_bank.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(waste_bank $waste_bank, $id)
    {
        $DestroyWasteBank = waste_bank::findOrFail($id);
        //dd ($destroyScopeCategories);
        $DestroyWasteBank->delete();
        return redirect('wastebank_officer/waste_bank');
    }
}
