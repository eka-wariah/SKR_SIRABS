<?php

use App\Http\Controllers\AreaScopeController;
use App\Http\Controllers\CitizenApproveController;
use App\Http\Controllers\ConfirmmSubmission;
use App\Http\Controllers\Dashboard\CitizenDashboardController;
use App\Http\Controllers\Dashboard\RTDashboardController;
use App\Http\Controllers\Dashboard\RwDashboardController;
use App\Http\Controllers\Dashboard\TreasurerDashboardController;
use App\Http\Controllers\Dashboard\WasteBankDashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentCategoryController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationWaterController;
use App\Http\Controllers\ReportRetributionControllerController;
use App\Http\Controllers\RTCitizenController;
use App\Http\Controllers\RTController;
use App\Http\Controllers\RTDashboard;
use App\Http\Controllers\RTRegWaterController;
use App\Http\Controllers\RTReportRetribution;
use App\Http\Controllers\SubmissionFundController;
use App\Http\Controllers\TrashCategoryController;
use App\Http\Controllers\TreasurerController;
use App\Http\Controllers\TreasurerFinanceController;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\WasteBankCashController;
use App\Http\Controllers\WasteBankCitizenController;
use App\Http\Controllers\WasteBankController;
use App\Http\Controllers\WasteBankReportController;
use App\Http\Controllers\WasteBankTreasurerController;
use App\Http\Controllers\WasteBankWithdrawalController;
use App\Models\area_scope;
use App\Models\UserNotification;
use App\Models\WasteBankWithdrawal;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/verification/pending', function () {
    return view('auth.pending');
})->name('verification.pending');


Route::middleware(['auth', 'role:rw_leader'])->group(function () {
    Route::get('/rw_leader', [RwDashboardController::class, 'index'])->name('dashboard');
    Route::get('/rw_leader/area_scope', [AreaScopeController::class, 'index'])->name('area_scope');
    Route::get('/rw_leader/area_scope/create', [AreaScopeController::class, 'create'])->name('area_scope.create');
    Route::post('/rw_leader/area_scope/create', [AreaScopeController::class, 'store'])->name('area_scope.store');
    Route::get('/rw_leader/area_scope/{id}/edit',[AreaScopeController::class, 'edit'])->name('area_scope.edit');
    Route::post('/rw_leader/area_scope/{id}/edit',[AreaScopeController::class, 'update'])->name('area_scope.update');
    Route::delete('/rw_leader/area_scope/{id}/destroy',[AreaScopeController::class, 'destroy'])->name('area_scope.destroy');
    Route::get('/rw_leader/data_rt', [TreasurerController::class, 'index'])->name('treasurer.index');
    Route::get('/rw_leader/treasurer/create', [TreasurerController::class, 'create'])->name('treasurer.create');
    Route::post('/rw_leader/treasurer/create', [TreasurerController::class, 'store'])->name('treasurer.store');
    Route::delete('/rw_leader/treasurer/{id}/destroy', [TreasurerController::class, 'destroy'])->name('treasurer.destroy');
    Route::resource('rw_leader/treasurer', TreasurerController::class);
    Route::get('/get-citizens/{area_scope_id}', [TreasurerController::class, 'getCitizens']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Halaman index, form tambah, proses simpan, get warga
    Route::get('/rw_leader/data_rt', [RTController::class, 'index'])->name('rt.index');
    Route::get('/rw_leader/data_rt/create', [RTController::class, 'create'])->name('rt.create');
    Route::post('/rw_leader/data_rt/store', [RTController::class, 'store'])->name('rt.store');
    Route::delete('/rw_leader/data_rt/{id}/destroy', [RTController::class, 'destroy'])->name('rt.destroy');
    Route::get('/get-citizenss/{asc_id}', [RTController::class, 'getCitizens']);
    Route::delete('/rw_leader/data_rt/{id}', [RTController::class, 'destroy'])->name('rt.destroy');
    Route::get('/rw_leader/report', [ReportRetributionControllerController::class, 'index'])->name('rw.laporan.index');

    // Route::delete('/rw_leader/treasurer/{user}/{id}', [TreasurerController::class, 'destroy'])->name('treasurer.destroy');
    //Route::delete('/rw_leader/treasurer/{id}/destroy',[TreasurerController::class, 'destroy'])->name('treasurer.destroy');   
    // //Route::post('/treasurer/promote/{user}', [TreasurerController::class, 'promote'])->name('treasurer.promote');

});

// Route::middleware(['auth', 'role:wastebank_officer'])->group(function () {
//     Route::get('/wastebank_officer', function(){
//         return view('wastebank_officer.dashboard_petugas');;
//     });
Route::middleware(['auth', 'role:wastebank_officer'])->group(function () {
    Route::get('/wastebank_officer', [WasteBankDashboardController::class, 'index'])->name('wastebank_officer');
    Route::get('/wastebank_officer/trash_category', [TrashCategoryController::class, 'index'])->name('trash_category');
    Route::get('/wastebank_officer/trash_category/create', [TrashCategoryController::class, 'create'])->name('trash_category.create');
    Route::post('/wastebank_officer/trash_category/create', [TrashCategoryController::class, 'store'])->name('trash_category.store');
    Route::get('/wastebank_officer/trash_category/{id}/edit',[TrashCategoryController::class, 'edit'])->name('trash_category.edit');
    Route::post('/wastebank_officer/trash_category/{id}/edit',[TrashCategoryController::class, 'update'])->name('trash_category.update');
    Route::delete('/wastebank_officer/trash_category/{id}/destroy',[TrashCategoryController::class, 'destroy'])->name('trash_category.destroy');
    
    Route::get('/wastebank_officer/waste_bank', [WasteBankController::class, 'index'])->name('waste_bank.index');
    Route::get('/wastebank_officer/waste_bank/create', [WasteBankController::class, 'create'])->name('waste_bank.create');
    Route::post('/wastebank_officer/waste_bank/create', [WasteBankController::class, 'store'])->name('waste_bank.store');
    Route::get('/wastebank_officer/waste_bank/{id}/edit',[WasteBankController::class, 'edit'])->name('waste_bank.edit');
    Route::put('/wastebank_officer/waste_bank/{id}/edit',[WasteBankController::class, 'update'])->name('waste_bank.update');
    Route::delete('/wastebank_officer/waste_bank/{id}/destroy',[WasteBankController::class, 'destroy'])->name('waste_bank.destroy');   
    Route::get('/wastebank_officer/waste_bank/{id}', [WasteBankController::class, 'show'])->name('waste_bank.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/wastebank_officer/submission', [SubmissionFundController::class, 'index_officer'])->name('submission.index_officer');
    Route::post('/wastebank_officer/submission/{id}', [SubmissionFundController::class, 'mark_submitted'])->name('submission.mark_submitted');
    Route::get('/submission/data', [SubmissionFundController::class, 'getData'])->name('submission.data');
    Route::get('/submission/total', [SubmissionFundController::class, 'getTotal'])->name('submission.total');
    // web.php 
    Route::get('/laporan/bank-sampah/data', [WasteBankReportController::class, 'getData'])->name('wastebank.report.data');
    Route::get('/laporan/bank-sampah/total', [WasteBankReportController::class, 'getTotal'])->name('wastebank.report.total');
    Route::post('/laporan/bank-sampah/tandai/{id}', [WasteBankReportController::class, 'tandai'])->name('wastebank.report.tandai');

    Route::get('/wastebank_officer/withdraw', [WasteBankWithdrawalController::class, 'index'])->name('withdraw.index');
    Route::get('/wastebank_officer/withdraw/{usr_id}/create', [WasteBankWithdrawalController::class, 'create'])->name('withdraw.create');
    Route::post('/wastebank_officer/withdraw/store', [WasteBankWithdrawalController::class, 'store'])->name('withdraw.store');
    Route::get('/withdraw/users/{scopeId}', [WasteBankWithdrawalController::class, 'getUsersByScope'])->name('withdraw.users');

    Route::get('/wastebank_officer/cashflow', [WasteBankCashController::class, 'index'])->name('cash.index');
    Route::get('/wastebank_officer/cashflow/create', [WasteBankCashController::class, 'create'])->name('cash.create');
    Route::post('/wastebank_officer/cashflow/store', [WasteBankCashController::class, 'store'])->name('cash.store');
    Route::post('/wastebank_officer/cashflow/store', [WasteBankCashController::class, 'store'])->name('cash.store');
    


});
    
Route::middleware(['auth', 'role:citizen'])->group(function () {
    Route::get('/citizen', [CitizenDashboardController::class, 'index'])->name('citizen.dashboard');
    Route::get('/citizen/waste_bank', [WasteBankCitizenController::class, 'index'])->name('waste_bank_citizen.index');   
    Route::get('/citizen/waste_bank/{id}', [WasteBankCitizenController::class, 'show'])->name('waste_bank_citizen.show');

    Route::get('/citizen/payment', [PaymentsController::class, 'index'])->name('payment.index');
    Route::get('/citizen/payment/create_via_Waste_Bank', [PaymentsController::class, 'createWasteBank'])->name('payment.createWasteBank');
    Route::post('/citizen/payment/create_via_Waste_Bank', [PaymentsController::class, 'store'])->name('payment.store');
    Route::get('/citizen/payment/create_via_Bank', [PaymentsController::class, 'createPaymentGateway'])->name('payment.createPaymentGateway');
    Route::post('/citizen/payment/create_via_Bank', [PaymentsController::class, 'checkout'])->name('payment.checkout');
    Route::get('/citizen/payment/invoice/{id}', [PaymentsController::class, 'invoice'])->name('payment.invoice');
    Route::get('/citizen/payment/history', [PaymentsController::class, 'history'])->name('payment.history');
    Route::get('/citizen/profile', [ProfileController::class, 'edit_photo'])->name('citizen.profile.edit');
    Route::patch('/citizen/profile', [ProfileController::class, 'update_photo'])->name('citizen.profile.update');

    Route::get('/alamat/edit', [ProfileController::class, 'editAlamat'])->name('profile.editAlamat');
    Route::put('/alamat/update', [ProfileController::class, 'updateAlamat'])->name('profile.updateAlamat');
    Route::get('/citizen/water/register', [RegistrationWaterController::class, 'create'])->name('water.register.form');
    Route::post('/citizen/water/register', [RegistrationWaterController::class, 'store'])->name('water.register.store');
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{id}', [UserNotificationController::class, 'destroy'])->name('notifications.delete');

    // Route::get('/citizen/invoices', [InvoiceController::class, 'index'])->name('citizen.invoices.index');
    // Route::get('/citizen/invoices/{id}', [InvoiceController::class, 'show'])->name('citizen.invoices.show');
    Route::get('/citizen/invoices/{id}/pdf', [InvoiceController::class, 'pdf'])->name('citizen.invoices.pdf');
    Route::post('/citizen/invoices/{id}/pay', [InvoiceController::class, 'payNow'])->name('citizen.invoices.pay');
    // Route::get('/invoice/generate', [InvoiceController::class, 'generate'])->name('invoice.generate');
    Route::get('/citizen/invoices', [InvoiceController::class, 'index'])->name('citizen.invoices.index');
    Route::get('/citizen/invoices/{id}', [InvoiceController::class, 'show'])->name('citizen.invoices.show');

    
});

Route::middleware(['auth', 'role:treasurer'])->group(function () {
    Route::get('/treasurer', [TreasurerDashboardController::class, 'index'])->name('treasurer.dashboard');
    Route::get('/treasurer/payment_category', [PaymentCategoryController::class, 'index'])->name('payment_category');
    Route::get('/treasurer/payment_category/create', [PaymentCategoryController::class, 'create'])->name('payment_category.create');
    Route::post('/treasurer/payment_category/create', [PaymentCategoryController::class, 'store'])->name('payment_category.store');
    Route::get('/treasurer/payment_category/{id}/edit',[PaymentCategoryController::class, 'edit'])->name('payment_category.edit');
    Route::post('/treasurer/payment_category/{id}/edit',[PaymentCategoryController::class, 'update'])->name('payment_category.update');
    Route::delete('/treasurer/payment_category/{id}/destroy',[PaymentCategoryController::class, 'destroy'])->name('payment_category.destroy');

    Route::get('/treasurer/waste_bank', [WasteBankTreasurerController::class, 'index'])->name('waste_bank_treasurer.index');   
    Route::get('/treasurer/waste_bank/{id}', [WasteBankTreasurerController::class, 'show'])->name('waste_bank_treasurer.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/treasurer/confirm_submission', [ConfirmmSubmission::class, 'index_treasurer'])->name('submission.index_treasurer');
    Route::get('/treasurer/confirm_submission/data', [ConfirmmSubmission::class, 'getDataConfirm'])->name('confirm_submission.getDataConfirm');
    Route::post('/treasurer/confirm_submission/confirm/{id}', [ConfirmmSubmission::class, 'confirm'])->name('confirm_submission.confirm');
    Route::get('/treasurer/confirm_submission/total', [ConfirmmSubmission::class, 'getTotal'])->name('confirm_submission.total');

    Route::get('/treasurer/finance', [TreasurerFinanceController::class, 'index'])->name('treasurer.finance.index');
    // Route::get('/treasurer/finance/data', [TreasurerFinanceController::class, 'getFinanceData'])->name('treasurer.finance.data');
    Route::get('/treasurer/finance/data', [TreasurerFinanceController::class, 'data'])->name('treasurer.finance.data');

    Route::get('/treasurer/finance/payment/create', [TreasurerFinanceController::class, 'createPayment'])->name('treasurer.finance.payment.create');
    Route::post('/treasurer/finance/payment/create', [TreasurerFinanceController::class, 'storePayment'])->name('treasurer.finance.payment.store');
    Route::post('/treasurer/finance/expense', [TreasurerFinanceController::class, 'storeExpense'])->name('treasurer.finance.expense.store');
    Route::put('/treasurer/finance/expense/{id}', [TreasurerFinanceController::class, 'updateExpense'])->name('treasurer.finance.expense.update');

    Route::get('/treasurer/profile', [ProfileController::class, 'edit_photo'])->name('treasurer.profile.edit');
    Route::patch('/treasurer/profile', [ProfileController::class, 'update_photo'])->name('treasurer.profile.update');

    Route::get('/treasurer/invoices', [InvoiceController::class, 'index'])->name('treasurer.invoices.index');

    // API
    Route::get('/api/payment-total', function (Request $request) {
        if ($request->type === 'combined') {
            $air = \App\Models\payment_category::where('pym_name', 'like', '%Air%')->first()?->pym_total ?? 0;
            $sampah = \App\Models\payment_category::where('pym_name', 'like', '%Sampah%')->first()?->pym_total ?? 0;
            return response()->json(['total' => $air + $sampah]);
        }
    
        $kategori = \App\Models\payment_category::find($request->id);
        return response()->json(['total' => $kategori?->pym_total ?? 0]);
    })->name('api.payment.total');
    
    Route::get('/treasurer/finance/report/cashflow/download', [TreasurerFinanceController::class, 'downloadCashflow'])->name('treasurer.finance.cashflow.download');

    Route::get('/treasurer/report/upload', [ReportRetributionControllerController::class, 'form'])->name('treasurer.laporan.form');
    Route::post('/treasurer/report/upload', [ReportRetributionControllerController::class, 'upload'])->name('treasurer.laporan.upload');

    // Notifikasi
    Route::get('/notifications/delete/{id}', function ($id) {
        auth()->user()->notifications()->findOrFail($id)->delete();
        return back();
    })->name('notifications.delete');

    Route::post('/notifications/read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read');


    });

Route::middleware(['auth', 'role:rt_leader'])->group(function () {
    Route::get('/rt_leader', [RTDashboardController::class, 'index'])->name('rt_leader.dashboard');
    Route::get('/rt_leader/treasurer', [TreasurerController::class, 'index'])->name('rt_leader.index');
    Route::get('/rt_leader/treasurer/create', [TreasurerController::class, 'create'])->name('rt_leader.create');
    Route::get('/rt_leader/citizen', [RTCitizenController::class, 'index'])->name('rt_leader.citizen.index');
    Route::get('/rt_leader/citizen/create', [RTCitizenController::class, 'create'])->name('rt_leader.citizen.create');
    Route::post('/rt_leader/citizen/create', [RTCitizenController::class, 'store'])->name('rt_leader.citizen.store');
    Route::get('/rt_leader/registration_water', [RTRegWaterController::class, 'index'])->name('rt_leader.registration_water.index');
    Route::post('/rt_leader/registration_water/{id}/verifikasi', [RTRegWaterController::class, 'verifikasi'])->name('rt_leader.registration_water.verifikasi');
    Route::get('/rt_leader/registration_water/{id}', [RTRegWaterController::class, 'show'])->name('rt_leader.registration_water.show');
    Route::put('/rt_leader/registration_water/{id}', [RTRegWaterController::class, 'update'])->name('rt_leader.registration_water.update');
    Route::get('/rt_leader/treasurer', [TreasurerController::class, 'index'])->name('treasurer.index');
    Route::get('/rt_leader/treasurer/create', [TreasurerController::class, 'create'])->name('treasurer.create');
    Route::post('/rt_leader/treasurer/create', [TreasurerController::class, 'store'])->name('treasurer.store');
    Route::delete('/rt_leader/treasurer/{id}/destroy', [TreasurerController::class, 'destroy'])->name('treasurer.destroy');
    Route::get('/rt_leader/approve', [CitizenApproveController::class, 'index'])->name('rt.approval');
    Route::post('/rt_leader/approve/{id}', [CitizenApproveController::class, 'approve'])->name('rt.approve.user');
    Route::resource('rt_leader/treasurer', TreasurerController::class);
    Route::get('/get-citizens/{area_scope_id}', [TreasurerController::class, 'getCitizens']);
    Route::get('/rt_leader/retributions', [RTReportRetribution::class, 'index'])->name('rt.retributions.index');
    Route::get('/rt_leader/retributions/summary', [RTReportRetribution::class, 'summaryPartial']);
    Route::get('/rt_leader/retributions/data', [RTReportRetribution::class, 'ajaxData']);
    Route::get('/rt_leader/retributions/pdf', [RTReportRetribution::class, 'exportPdf'])->name('rt.retributions.pdf');
Route::get('/rt_leader/retributions/detail', [RTReportRetribution::class, 'detail'])->name('rt.retribution.detail');
Route::get('/rt_leader/profile', [ProfileController::class, 'edit_photo'])->name('rt_leader.profile.edit');
Route::patch('/rt_leader/profile', [ProfileController::class, 'update_photo'])->name('rt_leader.profile.update');

    
});

Route::get('/email-test', function () {
    \Illuminate\Support\Facades\Mail::raw('Ini adalah test email dari SiTAW!', function ($message) {
        $message->to('ekawariah877@gmail.com')
                ->subject('Tes Email dari Laravel');
    });

    return 'Email test sudah dikirim!';
});

Route::get('/tes-scope', function () {
    return area_scope::all(); // atau AreaScope jika itu modelnya
});


require __DIR__.'/auth.php';
