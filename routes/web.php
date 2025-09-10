<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Categories
Route::resource('categories', CategoryController::class);

// Sources
Route::resource('sources', SourceController::class);

// Transactions (tanpa show karena tidak ada detail transaksi)
Route::resource('transactions', TransactionController::class)->except(['show']);

// Goals
Route::resource('goals', GoalController::class);

// Export PDF transaksi
Route::get('/transactions/export/pdf/{type}/{range}', [TransactionController::class, 'exportPdf'])
    ->name('transactions.export.pdf');

// Export Excel transaksi
Route::get('/transactions/export/excel/{type}/{range}', [TransactionController::class, 'exportExcel'])
    ->name('transactions.export.excel');

