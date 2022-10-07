<?php

use App\Http\Controllers\Dashboard;
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

Route::get('/', [Dashboard::class, 'indexAction']);
Route::get('/customers', [Dashboard::class, 'indexAction']);
Route::get('/orders', [Dashboard::class, 'indexAction']);
Route::get('/invoices', [Dashboard::class, 'indexAction']);
