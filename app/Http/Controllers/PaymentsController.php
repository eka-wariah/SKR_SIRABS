<?php

namespace App\Http\Controllers;

use App\Models\payment_category;
use App\Models\payments;
use App\Models\User;
use App\Models\waste_bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user(); // ambil user yang sedang login
        $saldoBankSampah = $user->total_money;
        $biayaYangDibutuhkan = payment_category::min('pym_total');
        $pendingPayments = payments::with(['user', 'paymentCategory']) // pastikan relasi sudah ada
        ->where('status', 'pending')
        ->get();
        return view('citizen.payment.index', compact('saldoBankSampah','biayaYangDibutuhkan', 'pendingPayments' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createWasteBank()
    {
        $user = auth()->user();
        $WasteBank = waste_bank::where('wtb_name_id', $user->usr_id)->first();
        $saldoBankSampah = $user->total_money;
        $PaymentCategory = payment_category::all();
        return view('citizen.payment.via_wastebank.create', compact('saldoBankSampah', 'user', 'PaymentCategory'));
    }
    public function createPaymentGateway()
    {
        $user = auth()->user();
        $WasteBank = waste_bank::where('wtb_name_id', $user->usr_id)->first();
        $saldoBankSampah = $user->total_money;
        $PaymentCategory = payment_category::all();
        return view('citizen.payment.via_bank.create', compact('saldoBankSampah', 'user', 'PaymentCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'metode_bayar' => 'required|in:bank_sampah,digital',
            'payment_category_id' => 'required|exists:payment_categories,pym_id',
        ]);
    
        $user = Auth::user();
        $category = payment_category::findOrFail($request->payment_category_id);
        $jumlah = $category->pym_total;
    
        // Dapatkan bendahara berdasarkan wilayah user
        $treasurer = User::role('treasurer') // pakai helper dari Spatie
            ->where('usr_scope_id', $user->usr_scope_id)
            ->first();
    
            if ($request->metode_bayar === 'bank_sampah') {
                if ($user->total_money < $jumlah) {
                    return back()->with('error', 'Saldo tidak cukup untuk membayar.');
                }
            
                $user->total_money -= $jumlah;
                $user->save();
            }
    // } else {
            // Proses ke payment gateway di sini...
            // Simulasikan sebagai "pending" untuk sekarang
        // }
    
        payments::create([
            'pyn_user_id' => $user->usr_id,
            'pyn_treasurer_id' => $treasurer ? $treasurer->usr_id : null,
            'pyn_payment_category_id' => $category->pym_id,
            'jumlah_bayar' => $jumlah,
            'metode_bayar' => $request->metode_bayar,
            'status' => $request->metode_bayar === 'bank_sampah' ? 'lunas' : 'pending',
        ]);
    
        return redirect('/citizen/payment');
        
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
    $category = payment_category::findOrFail($request->payment_category_id);
    $jumlah = $category->pym_total;

    // Cari bendahara berdasarkan wilayah
    $treasurer = User::role('treasurer')
        ->where('usr_scope_id', $user->usr_scope_id)
        ->first();

    // Buat pembayaran sementara
    $payment = payments::create([
        'pyn_user_id' => $user->usr_id,
        'pyn_treasurer_id' => $treasurer?->usr_id,
        'pyn_payment_category_id' => $category->pym_id,
        'jumlah_bayar' => $jumlah,
        'metode_bayar' => $request->metode_bayar,
        'status' => 'pending',
    ]);

    // Konfigurasi Midtrans
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $params = [
        'transaction_details' => [
            'order_id' => $payment->pyn_id . '-' . Str::uuid(), // pastikan unik
            'gross_amount' => $jumlah,
        ],
        'customer_details' => [
            'first_name' => $user->name,
        ],
    ];

    // Generate Snap Token
    try {
        $snapToken = \Midtrans\Snap::getSnapToken($params);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal membuat token Midtrans: ' . $e->getMessage());
    }

    return view('citizen.payment.via_bank.checkout', compact('snapToken', 'payment'));
}
//         $user = Auth::user();
//         $category = payment_category::findOrFail($request->payment_category_id);
//         $jumlah = $category->pym_total;
    
//         // Dapatkan bendahara berdasarkan wilayah user
//         $treasurer = User::role('treasurer') // pakai helper dari Spatie
//             ->where('usr_scope_id', $user->usr_scope_id)
//             ->first();

//         $PaymentGateway = payments::create([
//             'pyn_user_id' => $user->usr_id,
//             'pyn_treasurer_id' => $treasurer ? $treasurer->usr_id : null,
//             'pyn_payment_category_id' => $category->pym_id,
//             'jumlah_bayar' => $jumlah,
//             'metode_bayar' => $request->metode_bayar,
//             'status' =>'pending',
//         ]);
//         // Set your Merchant Server Key
//             \Midtrans\Config::$serverKey = config('midtrans.server_key');
//             // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
//             \Midtrans\Config::$isProduction = false;
//             // Set sanitization on (default)
//             \Midtrans\Config::$isSanitized = true;
//             // Set 3DS transaction for credit card to true
//             \Midtrans\Config::$is3ds = true;

//             $params = array(
//                 'transaction_details' => array(
//                     'order_id' => 'ORDER-' .$PaymentGateway->pyn_id,
//                     'gross_amount' => $PaymentGateway->paymentCategory->pym_total,
//                 ),
//                 'customer_details' => array(
//                     'first_name' => $user->usr_id,
                    
//                 ),
// );

// $snapToken = Snap::getSnapToken($params);
// dd($snapToken);
//return view('citizen.payment.via_bank.checkout', compact('snapToken', 'PaymentGateway'));

     /**
     * Display the specified resource.
     */

     public function checkoutExisting($id)
     {
         $payment = payments::with(['user', 'treasurer', 'paymentCategory'])->findOrFail($id);
     
         // Konfigurasi Midtrans
         \Midtrans\Config::$serverKey = config('midtrans.server_key');
         \Midtrans\Config::$isProduction = false;
         \Midtrans\Config::$isSanitized = true;
         \Midtrans\Config::$is3ds = true;
     
         $params = [
             'transaction_details' => [
                 'order_id' => $payment->pyn_id . '-' . Str::uuid(),
                 'gross_amount' => $payment->jumlah_bayar,
             ],
             'customer_details' => [
                 'first_name' => $payment->user->name,
             ],
         ];
     
         try {
             $snapToken = \Midtrans\Snap::getSnapToken($params);
         } catch (\Exception $e) {
             return redirect()->back()->with('error', 'Gagal membuat token Midtrans: ' . $e->getMessage());
         }
     
         return view('citizen.payment.via_bank.checkout', compact('snapToken', 'payment'));
     }

    public function callback(Request $request){
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if ($hashed === $request->signature_key) {
            if ($request->transaction_status == 'capture') {
                // Ambil payment_id dari order_id Midtrans
                $orderIdParts = explode('-', $request->order_id);
                $paymentId = $orderIdParts[0]; // ambil bagian sebelum UUID
    
                $order = payments::find($paymentId);
    
                if ($order && $order->status !== 'lunas') {
                    $order->update(['status' => 'lunas']);
                }
            }
       
            }
    }

    public function invoice($id)
    {
        $user = auth()->user();
        $payment = payments::with('paymentCategory', 'treasurer')
        ->where('pyn_user_id', $user->usr_id)
        ->where('pyn_id', $id) // cari berdasarkan ID invoice
        ->firstOrFail();
        return view('citizen.payment.invoice', compact('user', 'payment'));
    }

    public function history(payments $payments)
    {
        $user = auth()->user();

    // Ambil semua pembayaran user ini, urut terbaru
        $History = payments::where('pyn_user_id', $user->usr_id)
            ->with('paymentCategory','treasurer') // jika ingin tampilkan nama kategori
            ->orderBy('pyn_created_at', 'desc')
            ->get();
   
        return view('citizen.payment.history', compact('History'));
    }

    /**
     * Display the specified resource.
     */
    public function showPaymentOptions(payments $payments)
    {
        $user = auth()->user();

    // Ambil saldo user dari tabel users (misalnya)
    $saldo = $user->total_money;

    // Ambil biaya paling kecil dari semua kategori pembayaran
    $biayaYangDibutuhkan = payment_category::min('pym_total');

    return view('citizen.payment.options', compact('saldo', 'biayaYangDibutuhkan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payments $payments)
    {
        //
    }
}
