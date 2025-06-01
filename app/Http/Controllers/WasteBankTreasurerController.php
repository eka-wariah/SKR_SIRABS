<?php

namespace App\Http\Controllers;

use App\Models\trash_category;
use App\Models\User;
use App\Models\waste_bank;
use Illuminate\Http\Request;

class WasteBankTreasurerController extends Controller
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
    
        return view('treasurer.waste_bank.index', compact(['waste_bank', 'users', 'trash_category', 'total_uang', 'year', 'month']));
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
        $waste_bank = waste_bank::with('details.trashCategory')->findOrFail($id);

        return view('treasurer.waste_bank.show', compact('waste_bank'));
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
