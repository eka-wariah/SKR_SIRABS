<?php

namespace App\Http\Controllers;

use App\Mail\SendCredentials;
use App\Models\households;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RTCitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rt = Auth::user(); // yang login adalah RT
        // Ambil semua warga di RT tersebut + relasi KK
    $warga = User::role('citizen')
    ->where('usr_scope_id', $rt->usr_scope_id)
    ->with('household')
    ->where('status', 1)
    ->get()
    ->groupBy('household_id');

// Konversi hasil groupBy ke koleksi agar bisa dipaginasi
$currentPage = request()->get('page', 1);
$perPage = 5;

// Paginasi manual berdasarkan KK
$paginatedKk = new \Illuminate\Pagination\LengthAwarePaginator(
    $warga->forPage($currentPage, $perPage)->values(),
    $warga->count(),
    $perPage,
    $currentPage,
    ['path' => request()->url(), 'query' => request()->query()]
);

return view('rt_leader.data_citizen.index', [
    'warga' => $warga->flatten(1), // tambahkan depth=1 biar jadi koleksi User
    'kkPaginated' => $paginatedKk
]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rt_leader.data_citizen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:users,nik',
            'kk' => 'required',
            'name' => 'required',
            'email' => 'nullable|email|unique:users,email',
            'gender' => 'required|in:Laki-laki,Perempuan',
        ]);

        // Cari atau buat household berdasarkan KK
        $household = households::firstOrCreate([
            'no_kk' => $request->kk,
        ]);

        // Buat password acak
        $password = Str::random(8);

        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'password' => Hash::make($password),
            'usr_scope_id' => Auth::user()->usr_scope_id,
            'household_id' => $household->id,
        ]);

        $user->assignRole('citizen');

        // Kirim password via email jika tersedia
        if ($user->email) {
            \Mail::to($user->email)->send(new \App\Mail\SendCredentials($user, $password));
        }

        return redirect()->back()->with('success', 'Warga berhasil ditambahkan.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storee(Request $request)
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
