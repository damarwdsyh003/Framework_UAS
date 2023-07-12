<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersC;

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

// LOGIN AND REGISTER
Route::get('/', function () {
    return view('login');
})->name('login');
Route::post('/', [UserController::class, 'login'])->name('postlogin');

// REGISTER PETUGAS
Route::get('/register-staf', function(){
    return view('/staf-tambah');
})->name('tambahstaf');
Route::post('/staf', [UserController::class, 'register3'])->name('registerstaf');

// REGISTER PENGGUNA
Route::get('/register', function(){
    return view('register');
});
Route::post('/postregister', [UserController::class, 'register1'])->name('postregister');

// REGISTER PENGGUNA
Route::get('/register', function(){
    return view('register');
});
Route::post('/postregister', [UserController::class, 'register2'])->name('postregister');

Route::get('/', function () {
    return view('welcome');
});
