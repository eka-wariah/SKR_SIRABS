<?php

namespace App\Http\Controllers;

use App\Models\area_scope;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AreaScopeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $area_scope = area_scope::all();
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('rw_leader.area_scope.index', compact(['area_scope']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rw_leader.area_scope.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $CreateAreaScope = area_scope::create([
            'asc_level' => $request->asc_level,
            'asc_number' => $request->asc_number
        ]);
        Alert::success('Berhasil Menambah', 'Berhasil menambahkan kategori lingkup wilayah');

        return redirect('rw_leader/area_scope');
    }

    /**
     * Display the specified resource.
     */
    public function show(area_scope $area_scope)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(area_scope $area_scope, $id)
    {
        $EditAreaScope = area_scope::findOrFail($id);
        return view('rw_leader.area_scope.edit', compact(['EditAreaScope']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, area_scope $area_scope, $id)
    {
        $UpdateAreaScope =area_scope::findOrFail($id); 
        $UpdateAreaScope->asc_level = $request->asc_level;
        $UpdateAreaScope->asc_number = $request->asc_number;
        $UpdateAreaScope->save();
        return redirect('rw_leader/area_scope');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(area_scope $area_scope, $id)
    {
        $DestroyAreaScope = area_scope::findOrFail($id);
        //dd ($destroyScopeCategories);
        $DestroyAreaScope->delete();
        return redirect('rw_leader/area_scope');
    }
}
