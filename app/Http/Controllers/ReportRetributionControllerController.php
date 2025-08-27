<?php

namespace App\Http\Controllers;

// use App\Models\ReportRetributionController;

use App\Models\UploadedReport;
use App\Models\User;
use App\Notifications\LaporanRetribusiNotification;
use App\Notifications\ReportRetributionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ReportRetributionControllerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');
        $month = $request->month;
    
         // Ambil semua notifikasi laporan yang masuk ke user RW
    $notifications = auth()->user()
    ->notifications()
    ->where('type', ReportRetributionNotification::class)
    ->latest()
    ->get()
    ->filter(function ($notif) use ($year, $month) {
        $createdAt = $notif->created_at;
        return $createdAt->year == $year && 
            ($month ? $createdAt->month == $month : true);
        });

return view('rw_leader.report_retribution.index', compact('notifications', 'year', 'month'));
    }

    public function form()
    {
        $uploadedReports = UploadedReport::where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('treasurer.finance.upload', compact('uploadedReports'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('pdf');
$namaFile = 'laporan_rt' . Auth::user()->usr_scope_id . '_' . now()->format('Y_m') . '.pdf';

// Simpan langsung ke folder public/laporan
$tujuan = public_path('laporan'); // => public/laporan
$file->move($tujuan, $namaFile);

// URL publikasi langsung
$fileUrl = asset('laporan/' . $namaFile);
        $namaBendahara = Auth::user()->name;
        $bulan = now()->translatedFormat('F');
        $tahun = now()->year;

        // Ambil nama RT
        $area = Auth::user()->areaScope;
        $rt = $area ? 'RT ' . $area->asc_number : 'RT Tidak Diketahui';

        // Notifikasi ke RW
        $rwUsers = User::role('rw_leader')->get();
        Notification::send($rwUsers, new ReportRetributionNotification($namaBendahara, $rt, $fileUrl, $bulan, $tahun));
        UploadedReport::create([
            'user_id' => Auth::id(),
            'file_url' => $fileUrl,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
        return back()->with('success', 'Laporan berhasil diupload dan notifikasi dikirim ke RW.');
    }

}


//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         //
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         //
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(ReportRetributionController $reportRetributionController)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(ReportRetributionController $reportRetributionController)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, ReportRetributionController $reportRetributionController)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(ReportRetributionController $reportRetributionController)
//     {
//         //
//     }
// }
