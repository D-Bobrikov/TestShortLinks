<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SourceController;
use Illuminate\Foundation\Application;
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
    return Inertia::render('Auth/Login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [SourceController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::delete('/dashboard/delete/{id}', [SourceController::class, 'destroy'])->middleware(['auth', 'verified'])->name('dashboard.delete');
    Route::post('/dashboard/store/', [SourceController::class, 'store'])->middleware(['auth', 'verified'])->name('dashboard.store');
    Route::get('/dashboard/edit/', [SourceController::class, 'edit'])->middleware(['auth', 'verified'])->name('dashboard.edit');
    Route::put('/dashboard/update/', [SourceController::class, 'update'])->middleware(['auth', 'verified'])->name('dashboard.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
