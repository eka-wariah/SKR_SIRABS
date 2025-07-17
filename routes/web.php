<?php

use App\Http\Controllers\AreaScopeController;
use App\Http\Controllers\ConfirmmSubmission;
use App\Http\Controllers\Dashboard\CitizenDashboardController;
use App\Http\Controllers\Dashboard\RTDashboardController;
use App\Http\Controllers\Dashboard\TreasurerDashboardController;
use App\Http\Controllers\Dashboard\WasteBankDashboardController;
use App\Http\Controllers\PaymentCategoryController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationWaterController;
use App\Http\Controllers\RTCitizenController;
use App\Http\Controllers\RTController;
use App\Http\Controllers\RTDashboard;
use App\Http\Controllers\RTRegWaterController;
use App\Http\Controllers\SubmissionFundController;
use App\Http\Controllers\TrashCategoryController;
use App\Http\Controllers\TreasurerController;
use App\Http\Controllers\TreasurerFinanceController;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\WasteBankCitizenController;
use App\Http\Controllers\WasteBankController;
use App\Http\Controllers\WasteBankReportController;
use App\Http\Controllers\WasteBankTreasurerController;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'role:rw_leader'])->group(function () {
    Route::get('/rw_leader', function () {
        return view('rw_leader.dashboard');
    });
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
    Route::post('/wastebank_officer/waste_bank/{id}/edit',[WasteBankController::class, 'update'])->name('waste_bank.update');
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
    Route::get('/citizen/profile', [ProfileController::class, 'edit_photo'])->name('profile.edit_photo');
    Route::patch('/citizen/profile', [ProfileController::class, 'update_photo'])->name('profile.update_photo');

    Route::get('/alamat/edit', [ProfileController::class, 'editAlamat'])->name('profile.editAlamat');
    Route::put('/alamat/update', [ProfileController::class, 'updateAlamat'])->name('profile.updateAlamat');
    Route::get('/citizen/water/register', [RegistrationWaterController::class, 'create'])->name('water.register.form');
    Route::post('/citizen/water/register', [RegistrationWaterController::class, 'store'])->name('water.register.store');
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{id}', [UserNotificationController::class, 'destroy'])->name('notifications.delete');
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
    Route::post('/treasurer/finance/payment', [TreasurerFinanceController::class, 'storePayment'])->name('treasurer.finance.payment.store');
    Route::post('/treasurer/finance/expense', [TreasurerFinanceController::class, 'storeExpense'])->name('treasurer.finance.expense.store');

});

Route::middleware(['auth', 'role:rt_leader'])->group(function () {
    Route::get('/rt_leader', [RTDashboardController::class, 'index'])->name('rt_leader.dashboard');
    Route::get('/rt_leader/treasurer', [TreasurerController::class, 'index'])->name('rt_leader.index');
    Route::get('/rt_leader/treasurer/create', [TreasurerController::class, 'create'])->name('rt_leader.create');
    Route::get('/rt_leader/citizen', [RTCitizenController::class, 'index'])->name('rt_leader.citizen.index');
    Route::get('/rt_leader/registration_water', [RTRegWaterController::class, 'index'])->name('rt_leader.registration_water.index');
    Route::post('/rt_leader/registration_water/{id}/verifikasi', [RTRegWaterController::class, 'verifikasi'])->name('rt_leader.registration_water.verifikasi');
    Route::get('/rt_leader/registration_water/{id}', [RTRegWaterController::class, 'show'])->name('rt_leader.registration_water.show');
    Route::put('/rt_leader/registration_water/{id}', [RTRegWaterController::class, 'update'])->name('rt_leader.registration_water.update');
    Route::get('/rt_leader/treasurer', [TreasurerController::class, 'index'])->name('treasurer.index');
    Route::get('/rt_leader/treasurer/create', [TreasurerController::class, 'create'])->name('treasurer.create');
    Route::post('/rt_leader/treasurer/create', [TreasurerController::class, 'store'])->name('treasurer.store');
    Route::delete('/rt_leader/treasurer/{id}/destroy', [TreasurerController::class, 'destroy'])->name('treasurer.destroy');
    Route::resource('rt_leader/treasurer', TreasurerController::class);
    Route::get('/get-citizens/{area_scope_id}', [TreasurerController::class, 'getCitizens']);
    
});

Route::get('/email-test', function () {
    \Illuminate\Support\Facades\Mail::raw('Ini adalah test email dari SiTAW!', function ($message) {
        $message->to('ekawariah877@gmail.com')
                ->subject('Tes Email dari Laravel');
    });

    return 'Email test sudah dikirim!';
});



require __DIR__.'/auth.php';
