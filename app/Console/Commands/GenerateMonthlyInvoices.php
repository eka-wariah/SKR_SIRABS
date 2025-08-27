<?php

namespace App\Console\Commands;

use App\Mail\InvoiceGeneratedMail;
use App\Models\households;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\PaymentCategory;
use App\Models\Invoice;
use App\Models\payment_category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class GenerateMonthlyInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generate monthly invoices for all users and payment categories';

    public function handle()
    {
        $month = Carbon::now()->format('Y-m');
        $this->info("Generating invoices for {$month}...");

        $users = User::all();
        $categories = payment_category::all();
        $households = households::with('waterRegistration')->get();

        $newCount = 0;
        $skipCount = 0;

        foreach ($households as $household) {
            foreach ($categories as $category) {
        
                // Cek invoice sudah ada untuk KK + kategori + periode?
                $exists = Invoice::where('household_id', $household->id)
                    ->where('payment_category_id', $category->pym_id)
                    ->where('periode', $month)
                    ->exists();
        
                if ($exists) {
                    echo "SKIP Invoice exists: Household {$household->id} - {$category->pym_name}\n";
                    continue;
                }
        
                if (strtolower($category->pym_name) === 'retribusi air') {
                    if (!$household->waterRegistration || $household->waterRegistration->rgw_status !== 'Aktif') {
                        echo "SKIP Air not active: Household {$household->id}\n";
                        continue;
                    }
                }
                // Untuk sampah gak perlu cek status, langsung buat invoice
        
                // Buat invoice per KK
                $invoice=Invoice::create([
                    'household_id' => $household->id,
                    'payment_category_id' => $category->pym_id,
                    'invoice_number' => strtoupper(uniqid('INV')),
                    'periode' => $month,
                    'due_date' => Carbon::now()->addDays(10),
                    'amount' => $category->pym_total,
                    'status' => 'pending',
                    'notes' => null,
                ]);
        
                echo "NEW Invoice: Household {$household->id} - {$category->pym_name} ({$month})\n";

                $user = $household->users()->first();
                if ($user && $user->email) {
                    Mail::to($user->email)->send(new InvoiceGeneratedMail($invoice));
                }
            }
        }
}
}