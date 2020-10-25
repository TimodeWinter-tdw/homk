<?php

use App\Http\Controllers\DebtItemController;
use App\Http\Controllers\ShoppingController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::prefix('shopping')->group(function() {
        Route::get('', [ShoppingController::class, 'index'])->name('shopping');
        Route::post('', [ShoppingController::class, 'create'])->name('shopping.create');
        Route::post('{id}', [ShoppingController::class, 'delete'])->name('shopping.delete');
    });

    Route::prefix('debt-management')->group(function() {
        Route::get('', [DebtItemController::class, 'index'])->name('debt-management');
    });
});
