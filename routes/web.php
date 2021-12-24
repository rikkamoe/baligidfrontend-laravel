<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\WisataController;

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

// Customer
Route::get('/', [HomeController::class, 'index']);
Route::get('/wisata', [WisataController::class, 'index']);

// Admin
Route::get('/admin/login', [LoginController::class, 'index']);
Route::post('/admin/login', [LoginController::class, 'login']);
Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/admin/logout/{token}', [DashboardController::class, 'logout'])->name('logout');
Route::get('/admin/view', [ViewController::class, 'index'])->name('view');
Route::post('/admin/view', [ViewController::class, 'create'])->name('viewpost');
