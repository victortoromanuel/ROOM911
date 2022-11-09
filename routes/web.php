<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminRoom911Controller;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AccessController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/menu', function () {
    return view('menu.menu');
});

Route::get('/login', function () {
    return view('login.login');
});

Route::post('/login', [AdminRoom911Controller::class, 'login'])->name('login');

Route::get('/access', function () {
    return view('access.access');
});

Route::post('/access', [AccessController::class, 'store'])->name('access');

Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');

Route::post('/employee', [EmployeeController::class, 'store'])->name('employee');

Route::get('/update/{id_employee}', [EmployeeController::class, 'show'])->name('update');

Route::patch('/update/{id_employee}', [EmployeeController::class, 'update'])->name('update-update');

Route::get('/admin', [AdminRoom911Controller::class, 'index'])->name('admin');

Route::post('/admin', [AdminRoom911Controller::class, 'store'])->name('admin');

Route::get('/menu/{id_admin_room_911}', [MenuController::class, 'index'])->name('menu');

Route::post('/menu/{id_admin_room_911}', [MenuController::class, 'filter'])->name('menu-edit');

Route::get('/history', function () {
    return view('history.history');
});