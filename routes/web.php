<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
        
        // History Pemesanan Admin
        Route::get('/admin/history', [App\Http\Controllers\BookingHistoryController::class, 'adminIndex'])->name('admin.history');
        Route::get('/admin/history/{id}', [App\Http\Controllers\BookingHistoryController::class, 'adminShow'])->name('admin.history.show');
        
        // Approval Pembayaran oleh Admin
        Route::get('/payment/approvals', [App\Http\Controllers\PaymentApprovalController::class, 'index'])->name('payment.approvals');
        Route::get('/payment/show/{id}', [App\Http\Controllers\PaymentApprovalController::class, 'show'])->name('payment.show');
        Route::post('/payment/approve/{id}', [App\Http\Controllers\PaymentApprovalController::class, 'approve'])->name('payment.approve');
        Route::post('/payment/reject/{id}', [App\Http\Controllers\PaymentApprovalController::class, 'reject'])->name('payment.reject');
        
        // User Management with legacy prefix for compatibility
        Route::resource('admin/users', App\Http\Controllers\Admin\UserManagementController::class, ['as' => 'admin']);
        
        // Master Data Management for Admin
        Route::resource('admin/maskapai', App\Http\Controllers\Admin\MaskapaiController::class, ['as' => 'admin']);
        Route::resource('admin/kota', App\Http\Controllers\Admin\KotaController::class, ['as' => 'admin']);
        Route::resource('admin/jadwal', App\Http\Controllers\Admin\JadwalPenerbanganController::class, ['as' => 'admin']);
        Route::resource('admin/tiket', App\Http\Controllers\Admin\TiketController::class, ['as' => 'admin']);
        
        // Monitoring for Admin
        Route::get('/admin/tickets', [App\Http\Controllers\Admin\MonitoringController::class, 'tickets'])->name('admin.tickets');
        Route::get('/admin/transactions', [App\Http\Controllers\Admin\MonitoringController::class, 'transactions'])->name('admin.transactions');
    });

    // Petugas Routes (accessible by petugas and admin)
    Route::middleware([\App\Http\Middleware\CheckRole::class.':petugas,admin'])->group(function () {
        Route::get('/petugas/tickets', [App\Http\Controllers\PetugasController::class, 'tickets'])->name('petugas.tickets');
        Route::get('/petugas/transactions', [App\Http\Controllers\PetugasController::class, 'transactions'])->name('petugas.transactions');
        
        // History Pemesanan Petugas
        Route::get('/petugas/history', [App\Http\Controllers\BookingHistoryController::class, 'petugasIndex'])->name('petugas.history');
        Route::get('/petugas/history/{id}', [App\Http\Controllers\BookingHistoryController::class, 'petugasShow'])->name('petugas.history.show');

        // CRUD Maskapai
        Route::resource('maskapai', App\Http\Controllers\MaskapaiController::class);
        // CRUD Kota
        Route::resource('kota', App\Http\Controllers\KotaController::class);
        // CRUD Jadwal Penerbangan
        Route::resource('jadwal', App\Http\Controllers\JadwalPenerbanganController::class);
        // CRUD Tiket (monitoring)
        Route::resource('tiket', App\Http\Controllers\TiketController::class)->only(['index', 'show', 'edit', 'update']);
        
        // New User Management System
        Route::resource('users', UserController::class);
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
