<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PointRedemptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('customers', CustomerController::class)->only(['index', 'create', 'store', 'show', 'update', 'edit', 'destroy']);
Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('redeem/create', [PointRedemptionController::class, 'create'])->name('redeem.create');
Route::post('redeem', [PointRedemptionController::class, 'store'])->name('redeem.store');
// web.php
Route::get('/redeem/history/{customer}', [\App\Http\Controllers\PointRedemptionController::class, 'history']);

Route::get('/search-customer', [CustomerController::class, 'search']);






require __DIR__.'/auth.php';

Route::get('/search-customer', function (\Illuminate\Http\Request $request) {
    $query = $request->get('query');

    $customers = \App\Models\Customer::where('name', 'like', "%{$query}%")
        ->orWhere('phone', 'like', "%{$query}%")
        ->limit(5)
        ->get(['id', 'name', 'phone']);

    return response()->json($customers);
});



Route::resource('customers', CustomerController::class);