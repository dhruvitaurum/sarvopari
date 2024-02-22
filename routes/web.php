<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\InstituteController;
use App\Http\Controllers\Admin\BoardController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\DoBusinessWithController;
use App\Http\Controllers\Admin\MediumController;
use App\Http\Controllers\Admin\StandardController;
use App\Http\Controllers\Admin\StreamController;
use App\Http\Controllers\Admin\StudentsController;
use App\Http\Controllers\Admin\SubjectController;
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

    //institute
    Route::get('institute_admin', [Users::class, 'list_institute'])->name('institute.list');
    Route::get('/create/institute', [InstituteController::class, 'create_institute'])->name('institute.create');
    Route::get('/institute-for/list', [InstituteController::class, 'list_institute_for'])->name('institute_for.list');
    Route::get('/create/institute_for', [InstituteController::class, 'create_institute_for'])->name('institute_for.create');
    Route::post('institute-for/save', [InstituteController::class, 'institute_for_save'])->name('institute_for.save');
    Route::post('/institute-for/edit', [InstituteController::class, 'institute_for_edit'])->name('institute_for.edit');
    Route::post('institute-for/update', [InstituteController::class, 'institute_for_update'])->name('institute.update');
    Route::post('institute-for/delete', [InstituteController::class, 'institute_for_delete'])->name('institute_for.delete');
    
    //board
    Route::get('/board/list', [BoardController::class, 'list_board'])->name('board.list');
    Route::get('create/board-list', [BoardController::class, 'create_board'])->name('board.create');
    Route::post('board-list/save', [BoardController::class, 'board_list_save'])->name('board_list.save');
    Route::post('/board-list/edit', [BoardController::class, 'board_list_edit'])->name('board_list.edit');
    Route::post('board/update', [BoardController::class, 'board_update'])->name('board.update');
    Route::post('/board/delete', [BoardController::class, 'board_delete'])->name('board.delete');
   
    //class
    Route::get('/class/list', [ClassController::class, 'list_class'])->name('class.list');
    Route::get('create/class-list', [ClassController::class, 'create_class'])->name('class.create');
    Route::post('class-list/save', [ClassController::class, 'class_list_save'])->name('class_list.save');
    Route::post('/class-list/edit', [ClassController::class, 'class_list_edit'])->name('class_list.edit');
    Route::post('class/update', [ClassController::class, 'class_update'])->name('class.update');
    Route::post('/class/delete', [ClassController::class, 'class_delete'])->name('class.delete');
   
    //medium
    Route::get('/medium/list', [MediumController::class, 'list_medium'])->name('medium.list');
    Route::get('create/medium', [MediumController::class, 'create_medium'])->name('medium.create');
    Route::post('medium-list/save', [MediumController::class, 'medium_list_save'])->name('medium_list.save');
    Route::post('/medium/edit', [MediumController::class, 'medium_list_edit'])->name('medium_list.edit');
    Route::post('medium/update', [MediumController::class, 'medium_update'])->name('medium.update');
    Route::post('/medium/delete', [MediumController::class, 'medium_delete'])->name('medium.delete');
    
    //standard
    Route::get('/standard/list', [StandardController::class, 'list_standard'])->name('standard.list');
    Route::get('create/standard-list', [StandardController::class, 'create_standard'])->name('standard.create');
    Route::post('standard-list/save', [StandardController::class, 'standard_list_save'])->name('standard_list.save');
    Route::post('/standard-list/edit', [StandardController::class, 'standard_list_edit'])->name('standard_list.edit');
    Route::post('standard/update', [StandardController::class, 'standard_update'])->name('standard.update');
    Route::post('/standard/delete', [StandardController::class, 'standard_delete'])->name('standard.delete');

     //stream
    Route::get('/stream/list', [StreamController::class, 'list_stream'])->name('stream.list');
    Route::get('create/stream-list', [StreamController::class, 'create_stream'])->name('stream.create');
    Route::post('stream-list/save', [StreamController::class, 'stream_list_save'])->name('stream_list.save');
    Route::post('/stream-list/edit', [StreamController::class, 'stream_list_edit'])->name('stream_list.edit');
    Route::post('stream/update', [StreamController::class, 'stream_update'])->name('stream.update');
    Route::post('/stream/delete', [StreamController::class, 'stream_delete'])->name('stream.delete');
   
    //subject
    Route::get('/subject/list', [SubjectController::class, 'list_subject'])->name('subject.list');
    Route::get('create/subject-list', [SubjectController::class, 'create_subject'])->name('subject.create');
    Route::POST('get/standard_wise_stream', [SubjectController::class, 'standard_wise_stream'])->name('standard_wise_stream.list');
    Route::post('subject-list/save', [SubjectController::class, 'subject_list_save'])->name('subject_list.save');
    Route::post('/subject/delete', [SubjectController::class, 'subject_delete'])->name('subject.delete');
    
    //do-business-with
    Route::get('/do-business-with/list', [DoBusinessWithController::class, 'list'])->name('do_business_with.list');
    Route::get('create/do-business-with', [DoBusinessWithController::class, 'create'])->name('do_business_with.create');
    Route::post('do-business-with/save', [DoBusinessWithController::class, 'save'])->name('do_business_with.save');
    Route::post('/do-business-with/edit', [DoBusinessWithController::class, 'edit'])->name('do_business_with.edit');
    Route::post('do-business-with/update', [DoBusinessWithController::class, 'update'])->name('do_business_with.update');
    Route::post('/do-business-with/delete', [DoBusinessWithController::class, 'delete'])->name('do_business_with.delete');
   
    //student
    Route::get('/student/list', [StudentsController::class, 'list_student'])->name('student.list');
    Route::get('/student/create', [StudentsController::class, 'create_student'])->name('student.create');
    Route::post('/student/save', [StudentsController::class, 'save_student'])->name('student.save');
    Route::post('/student/edit', [StudentsController::class, 'edit_student'])->name('student.edit');
    Route::post('/student/update', [StudentsController::class, 'update_student'])->name('student.update');
});


   
// Route::patch('/permissions/{user_id}', [PermissionController::class, 'update'])->middleware(['auth', 'verified'])->name('permissions.update');

require __DIR__.'/auth.php';
