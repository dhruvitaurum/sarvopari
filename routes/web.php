<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\InstituteController;
use App\Http\Controllers\Users;
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
Route::get('/create-role', [ProfileController::class, 'create_role'])->name('role.create');


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

    Route::get('create/role', [RoleController::class, 'create_role'])->name('roles.create');
    Route::post('roles/save', [RoleController::class, 'save_role'])->name('roles.insert');
    Route::get('list/roles', [RoleController::class, 'list_role'])->name('roles.list')->middleware('superadmin_permission');
    Route::post('/roles/edit', [RoleController::class, 'edit_role'])->name('roles.edit');
    Route::post('/roles/update', [RoleController::class, 'update_role'])->name('roles.update');
    Route::post('/roles/delete', [RoleController::class, 'delete_role'])->name('roles.delete');
    Route::get('/permission', [PermissionController::class, 'create_permission'])->name('permission.create');
    Route::post('permission/insert', [PermissionController::class, 'insert_permission'])->name('permission.insert');

    Route::get('admin', [Users::class, 'list_admin'])->name('admin.list');
    Route::get('create/admin', [Users::class, 'subadmin_create'])->name('admin.create');
    Route::post('store/admin', [Users::class, 'subadmin_store'])->name('admin.store');
    Route::post('admin/edit', [Users::class, 'subadmin_edit'])->name('admin.edit');
    Route::post('admin/update', [Users::class, 'subadmin_update'])->name('admin.update');
    Route::post('admin/delete', [Users::class, 'subadmin_delete'])->name('admin.delete');

    Route::get('institute_admin', [Users::class, 'list_institute'])->name('institute.list');
    Route::get('/create/institute', [InstituteController::class, 'create_institute'])->name('institute.create');

});



// Route::patch('/permissions/{user_id}', [PermissionController::class, 'update'])->middleware(['auth', 'verified'])->name('permissions.update');

require __DIR__.'/auth.php';
