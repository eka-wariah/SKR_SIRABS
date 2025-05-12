<?php

namespace App\Http\Controllers;

use App\Models\trash_category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TrashCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trash_category = trash_category::all();
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('wastebank_officer.trash_category.index', compact(['trash_category']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wastebank_officer.trash_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $CreateTrashCategory = trash_category::create([
            'trc_name' => $request->trc_name,
            'trc_price' => $request->trc_price,
        ]);
        Alert::success('Berhasil Menambah', 'Berhasil menambahkan kategori sampah dan harganya');

        return redirect('/wastebank_officer/trash_category');
    }

    /**
     * Display the specified resource.
     */
    public function show(trash_category $trash_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(trash_category $trash_category, $id)
    {
        $EditTrashCategory = trash_category::findOrFail($id);
        return view('wastebank_officer.trash_category.edit', compact(['EditTrashCategory']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, trash_category $trash_category, $id)
    {
        $UpdateTrashCategory =trash_category::findOrFail($id); 
        $UpdateTrashCategory->trc_name = $request->trc_name;
        $UpdateTrashCategory->trc_price = $request->trc_price;
        $UpdateTrashCategory->save();
        return redirect('/wastebank_officer/trash_category');
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(trash_category $trash_category, $id)
    {
        $DestroyTrashCategory = trash_category::findOrFail($id);
        //dd ($destroyScopeCategories);
        $DestroyTrashCategory->delete();
        return redirect('/wastebank_officer/trash_category');
    }
}
