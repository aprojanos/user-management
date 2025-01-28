<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AddressController;

Route::middleware(['auth', 'active-user'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/user-management', [UserManagementController::class, 'index'])->name('admin.user-management');
    Route::post('/user-management/bulk-action', [UserManagementController::class, 'bulkAction'])->name('admin.user-management.bulk-action');
    Route::get('/user-management/create', [UserManagementController::class, 'create'])->name('admin.user-management.create');
    Route::post('/user-management', [UserManagementController::class, 'store'])->name('admin.user-management.store');
    Route::get('/user-management/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.user-management.edit');
    Route::put('/user-management/{user}', [UserManagementController::class, 'update'])->name('admin.user-management.update');
    Route::delete('/user-management/{user}', [UserManagementController::class, 'destroy'])->name('admin.user-management.destroy');
    Route::get('/user-management/{user}/remove-profile-picture/', [UserManagementController::class, 'removeProfilePicture'])->name('admin.user-management.remove-profile-picture');

    Route::post('/address/{user}', [AddressController::class, 'store'])->name('address.store');
    Route::put('/address/{address}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/address/{address}', [AddressController::class, 'destroy'])->name('address.destroy');

});
