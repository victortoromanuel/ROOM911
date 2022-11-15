<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminRoom911Controller;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AccessController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Row;

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
    return view('login.login');
});

Route::get('/login', function () {
    return view('login.login');
});

Route::post('/login', [AdminRoom911Controller::class, 'login'])->name('login');

Route::get('/access', function () {
    return view('access.access');
});

Route::post('/access', [AccessController::class, 'store'])->name('access');

Route::get('/employee/{id_admin_room_911}', [EmployeeController::class, 'index'])->name('employee');

Route::post('/employee/{id_admin_room_911}', [EmployeeController::class, 'store'])->name('employee-store');

Route::get('/update/{id_admin_room_911}/{id_employee}', [EmployeeController::class, 'show'])->name('update');

Route::patch('/update/{id_admin_room_911}/{id_employee}', [EmployeeController::class, 'update'])->name('update-update');

Route::get('/admin/{id_admin_room_911}', [AdminRoom911Controller::class, 'index'])->name('admin');

Route::post('/admin/{id_admin_room_911}', [AdminRoom911Controller::class, 'store'])->name('admin-store');

Route::get('/menu/{id_admin_room_911}', [MenuController::class, 'index'])->name('menu');

Route::post('/menu/{id_admin_room_911}', [MenuController::class, 'filter'])->name('menu-edit');

Route::get('/import/{id_admin_room_911}', [EmployeeController::class, 'importView'])->name('import');

Route::post('/import/{id_admin_room_911}', [EmployeeController::class, 'uploadEmployees'])->name('employee-upload');

Route::patch('/disable/{id_employee}/{id_admin_room_911}', [MenuController::class, 'disable'])->name('disable');

Route::patch('/enable/{id_employee}/{id_admin_room_911}', [MenuController::class, 'enable'])->name('enable');

Route::delete('/delete/{id_employee}/{id_admin_room_911}', [MenuController::class, 'delete'])->name('delete');

/*Route::get('/history', function () {
    return view('history.history');
});*/

Route::get('history/{id_employee}', [MenuController::class, 'historyView'])->name('history');

#Route::get('history-export/{id_employee}', [MenuController::class, 'historyExport'])->name('history');

Route::post('history/{id_employee}', [MenuController::class, 'accessFilter'])->name('history-filter');