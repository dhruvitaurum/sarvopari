<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {

    switch (Auth::user()->role_type) {
        case '1':
            return view('dashboard01');
            break;

        case '2':
            return view('dashboard01');
            break;

        case '3':
            return view('dashboard01');
            break;
        
        
        default:
        return view('dashboard');
            break;
    }
    
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/sub_admin_list/{id}', [User::class, 'sub_admin_list'])->middleware(['auth', 'verified'])->name('sub_admin_list');
Route::get('/permissions/{user_id}', [PermissionController::class, 'edit'])->middleware(['auth', 'verified'])->name('permissions.edit');
Route::patch('/permissions/{user_id}', [PermissionController::class, 'update'])->middleware(['auth', 'verified'])->name('permissions.update');

require __DIR__.'/auth.php';
