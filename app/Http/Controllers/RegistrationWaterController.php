<?php

namespace App\Http\Controllers;

use App\Models\registration_water;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationWaterController extends Controller
{
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
        $user = Auth::user();

        $existing = registration_water::where('rgw_household_id', $user->household_id)->first();

        return view('citizen.registration_water.create', [
            'existing' => $existing,
            'defaultAddress' => $user->address,
        ]);
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Handle alamat
        $address = $request->input('address') ?? $user->address;

    // Simpan foto
    $photoPath = null;
    if ($request->hasFile('rgw_house_photo')) {
        $photoPath = $request->file('rgw_house_photo')->store('house_photos', 'public');
    }
    

    registration_water::create([
        'rgw_household_id' => $user->household_id,
        'rgw_applicant_id' => $user->usr_id,
        'rgw_registration_date' => now(),
        'rgw_status' => 'Menunggu Verifikasi',
        'rgw_notes' => $request->rgw_notes,
        'address' => $address,
        'rgw_house_photo' => $photoPath,
    ]);
 
    return redirect('/citizen')->with('success', 'Pendaftaran berhasil dikirim.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(registration_water $registration_water)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(registration_water $registration_water)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, registration_water $registration_water)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(registration_water $registration_water)
    {
        //
    }
}
