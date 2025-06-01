<?php

use App\Http\Controllers\AreaScopeController;
use App\Http\Controllers\Dashboard\CitizenDashboardController;
use App\Http\Controllers\Dashboard\TreasurerDashboardController;
use App\Http\Controllers\Dashboard\WasteBankDashboardController;
use App\Http\Controllers\PaymentCategoryController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrashCategoryController;
use App\Http\Controllers\TreasurerController;
use App\Http\Controllers\WasteBankCitizenController;
use App\Http\Controllers\WasteBankController;
use App\Http\Controllers\WasteBankTreasurerController;
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

    Route::get('/rw_leader/treasurer', [TreasurerController::class, 'index'])->name('treasurer.index');
    Route::get('/rw_leader/treasurer/create', [TreasurerController::class, 'create'])->name('treasurer.create');
    Route::post('/rw_leader/treasurer/create', [TreasurerController::class, 'store'])->name('treasurer.store');
    Route::get('/get-citizens/{area_scope_id}', [TreasurerController::class, 'getCitizens']);
    Route::delete('/rw_leader/treasurer/{id}/destroy', [TreasurerController::class, 'destroy'])->name('treasurer.destroy');
    Route::resource('rw_leader/treasurer', TreasurerController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


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
    
});

require __DIR__.'/auth.php';
