<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware([\App\Http\Middleware\CheckRole::class.':admin'])->group(function () {
        Route::get('/admin/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports');
        Route::get('/admin/reports/sales', [App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('admin.reports.sales');
        Route::get('/admin/reports/export-sales', [App\Http\Controllers\Admin\ReportController::class, 'exportSales'])->name('admin.reports.export-sales');
        Route::get('/admin/reports/airlines', [App\Http\Controllers\Admin\ReportController::class, 'airlines'])->name('admin.reports.airlines');
        Route::get('/admin/reports/users', [App\Http\Controllers\Admin\ReportController::class, 'users'])->name('admin.reports.users');
        
        // Approval Pembayaran oleh Admin
        Route::get('/payment/approvals', [App\Http\Controllers\PaymentApprovalController::class, 'index'])->name('payment.approvals');
        Route::get('/payment/show/{id}', [App\Http\Controllers\PaymentApprovalController::class, 'show'])->name('payment.show');
        Route::post('/payment/approve/{id}', [App\Http\Controllers\PaymentApprovalController::class, 'approve'])->name('payment.approve');
        Route::post('/payment/reject/{id}', [App\Http\Controllers\PaymentApprovalController::class, 'reject'])->name('payment.reject');
        
        // User Management
        Route::resource('admin/users', App\Http\Controllers\Admin\UserManagementController::class, ['as' => 'admin']);
    });

    // Petugas Routes
    Route::middleware([\App\Http\Middleware\CheckRole::class.':petugas'])->group(function () {
        Route::get('/petugas/tickets', [App\Http\Controllers\PetugasController::class, 'tickets'])->name('petugas.tickets');
        Route::get('/petugas/transactions', [App\Http\Controllers\PetugasController::class, 'transactions'])->name('petugas.transactions');

        // CRUD Maskapai
        Route::resource('maskapai', App\Http\Controllers\MaskapaiController::class);
        // CRUD Kota
        Route::resource('kota', App\Http\Controllers\KotaController::class);
        // CRUD Jadwal Penerbangan
        Route::resource('jadwal', App\Http\Controllers\JadwalPenerbanganController::class);
        // CRUD Tiket (monitoring)
        Route::resource('tiket', App\Http\Controllers\TiketController::class)->only(['index', 'show', 'edit', 'update']);
    });

    // User Routes
    Route::middleware([\App\Http\Middleware\CheckRole::class.':user'])->group(function () {
        Route::get('/user/bookings', [App\Http\Controllers\UserBookingController::class, 'userBookings'])->name('user.bookings');
        Route::get('/user/history', [App\Http\Controllers\UserBookingController::class, 'history'])->name('user.history');
        Route::get('/booking/cetak/{id}', [App\Http\Controllers\UserBookingController::class, 'cetakTiket'])->name('booking.cetak');
        // CRUD Booking Tiket oleh User
        Route::resource('booking', App\Http\Controllers\UserBookingController::class);
    });
});

require __DIR__.'/auth.php';
