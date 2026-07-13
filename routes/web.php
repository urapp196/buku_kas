<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
