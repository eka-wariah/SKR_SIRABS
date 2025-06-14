<?php

namespace App\Http\Controllers;

use App\Models\payment_category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment_category = payment_category::all();
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('treasurer.payment_category.index', compact(['payment_category']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('treasurer.payment_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cleanTotal = str_replace(['Rp', '.', ' '], '', $request->pym_total);
        if ((int)$cleanTotal <= 10000) {
            return back()
                ->withErrors(['pym_total' => 'Pengisian Harus lebih dari RP 10.000'])
                ->withInput();
        }
        $CreatePaymentCategory = payment_category::create([
            'pym_name' => $request->pym_name,
            'pym_total' => $cleanTotal,
        ]);
        Alert::success('Berhasil Menambah', 'Berhasil menambahkan kategori sampah dan harganya');

        return redirect('/treasurer/payment_category');
    }

    /**
     * Display the specified resource.
     */
    public function show(payment_category $payment_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payment_category $payment_category, $id)
    {
        $EditPaymentCategory = payment_category::findOrFail($id);
        return view('treasurer.payment_category.edit', compact(['EditPaymentCategory']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, payment_category $payment_category, $id)
    {
        $cleanTotal = str_replace(['Rp', '.', ' '], '', $request->pym_total);
        if ((int)$cleanTotal <= 10000) {
            return back()
                ->withErrors(['pym_total' => 'Pengisian Harus lebih dari RP 10.000'])
                ->withInput();
        }
        $UpdatePaymentCategory =payment_category::findOrFail($id); 
        $UpdatePaymentCategory->pym_name = $request->pym_name;
        $UpdatePaymentCategory->pym_total = $cleanTotal;
        $UpdatePaymentCategory->save();
        return redirect('/treasurer/payment_category');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payment_category $payment_category, $id)
    {
        $DestroyPaymentCategory = payment_category::findOrFail($id);
        //dd ($destroyScopeCategories);
        $DestroyPaymentCategory->delete();
        return redirect('/treasurer/payment_category');
    }
}
