<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Services\MerchantService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
    Route::get('/get-reports/{fromDate}/{toDate}/{page}', [DashboardController::class, 'getReports'])->name('get-reports');
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
    Route::get('/get-transactions/{fromDate}/{toDate}/{page}', [DashboardController::class, 'getTransactions'])->name('get-transactions');
    Route::get('/get-transaction/{transactionId}', [DashboardController::class, 'getTransaction'])->name('get-transaction');
    Route::get('/clients', [DashboardController::class, 'clients'])->name('clients');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
