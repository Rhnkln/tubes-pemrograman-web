<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Semua route aplikasi web didefinisikan di sini
| Route akan otomatis menggunakan middleware "web"
|--------------------------------------------------------------------------
*/

// =======================
// Import Controller
// =======================
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;

// =======================
// Home / Landing Page
// =======================
Route::get('/', [HomeController::class, 'index'])
    ->name('welcome');

// =======================
// Authentication Routes
// =======================
Route::get('/register', [AuthController::class, 'showRegister'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// =======================
// User & Admin Dashboard
// =======================
Route::middleware(['auth', 'role:user,admin'])->group(function () {

    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [DashboardController::class, 'profile'])
        ->name('profile');

    Route::post('/profile', [DashboardController::class, 'updateProfile'])
        ->name('profile.update');

    // =======================
    // Lost Items Routes
    // =======================
    Route::get('/lost-items', [ReportController::class, 'lostItems'])
        ->name('lost-items');

    Route::get('/lost-items/create', [ReportController::class, 'createLostItem'])
        ->name('lost-items.create');

    Route::post('/lost-items', [ReportController::class, 'storeLostItem'])
        ->name('lost-items.store');

    Route::get('/lost-items/{lostItem}', [ReportController::class, 'showLostItem'])
        ->name('lost-items.show');

    Route::get('/lost-items/{lostItem}/edit', [ReportController::class, 'editLostItem'])
        ->name('lost-items.edit');

    Route::put('/lost-items/{lostItem}', [ReportController::class, 'updateLostItem'])
        ->name('lost-items.update');

    Route::delete('/lost-items/{lostItem}', [ReportController::class, 'destroyLostItem'])
        ->name('lost-items.destroy');

    // Update status barang hilang
    Route::patch('/lost-items/{item}/status', [ReportController::class, 'updateStatus'])
        ->name('lost-items.updateStatus')
        ->middleware('auth');

    // =======================
    // Found Items Routes
    // =======================
    Route::get('/found-items', [ReportController::class, 'foundItems'])
        ->name('found-items');

    Route::get('/found-items/create', [ReportController::class, 'createFoundItem'])
        ->name('found-items.create');

    Route::post('/found-items', [ReportController::class, 'storeFoundItem'])
        ->name('found-items.store');

    Route::get('/found-items/{foundItem}', [ReportController::class, 'showFoundItem'])
        ->name('found-items.show');

    Route::delete('/found-items/{foundItem}', [ReportController::class, 'destroyFoundItem'])
        ->name('found-items.destroy');

    // Edit & update laporan (umum)
    Route::get('/reports/{item}/edit', [ReportController::class, 'edit'])
        ->name('reports.edit');

    Route::put('/reports/{item}', [ReportController::class, 'update'])
        ->name('reports.update');

    Route::delete('/reports/{item}', [ReportController::class, 'destroy'])
        ->name('reports.destroy');

    // Update status barang temuan
    Route::patch('/found-items/{id}/status', [ReportController::class, 'updateStatus'])
        ->name('found-items.updateStatus');
});

// =======================
// Message / Chat Routes
// =======================
Route::middleware(['auth'])->group(function () {

    // Halaman chat
    Route::get('/messages/{itemType}/{itemId}', [MessageController::class, 'index'])
        ->name('messages.index');

    // Kirim pesan
    Route::post('/messages/{itemType}/{itemId}', [MessageController::class, 'store'])
        ->name('messages.store');
});

// =======================
// Admin Routes
// =======================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        // Manajemen User
        Route::get('/users', [AdminController::class, 'users'])
            ->name('users');

        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])
            ->name('users.destroy');

        // Laporan (Umum)
        Route::get('/reports', [AdminController::class, 'reports'])
            ->name('reports');

        Route::get('/reports/{report}', [AdminController::class, 'showReport'])
            ->name('reports.show');

        Route::put('/reports/{report}/status', [AdminController::class, 'updateReportStatus'])
            ->name('reports.update-status');

        Route::delete('/reports/{report}', [AdminController::class, 'destroyReport'])
            ->name('reports.destroy');

        // Lost Items Admin
        Route::get('/lost-items', [AdminController::class, 'lostItems'])
            ->name('lost-items');

        Route::put('/lost-items/{item}/status', [AdminController::class, 'updateLostItemStatus'])
            ->name('lost-items.update-status');

        Route::delete('/lost-items/{item}', [AdminController::class, 'destroyLostItem'])
            ->name('lost-items.destroy');

        // Found Items Admin
        Route::get('/found-items', [AdminController::class, 'foundItems'])
            ->name('found-items');

        Route::put('/found-items/{item}/status', [AdminController::class, 'updateFoundItemStatus'])
            ->name('found-items.update-status');

        Route::delete('/found-items/{item}', [AdminController::class, 'destroyFoundItem'])
            ->name('found-items.destroy');

        // Kategori
        Route::get('/categories', [AdminController::class, 'categories'])
            ->name('categories');

        Route::post('/categories', [AdminController::class, 'storeCategory'])
            ->name('categories.store');

        Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])
            ->name('categories.destroy');

        // Dashboard Admin (redundant route, tetap dipertahankan)
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard')
            ->middleware('auth', 'admin');
});
