<?php

use App\Http\Controllers\Customers;
use App\Http\Controllers\Orders;
use App\Http\Controllers\Invoices;
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
Route::get('/customers', [Customers::class, 'indexAction']);
Route::match(
    ['get', 'post'],
    '/customers/new',
    [Customers::class, 'newOrEditAction']
);
Route::match(
    ['get', 'post'],
    '/customers/edit/{id}',
    [Customers::class, 'newOrEditAction']
);
Route::get('/orders', [Orders::class, 'indexAction']);
Route::match(
    ['get', 'post'],
    '/orders/new',
    [Orders::class, 'newAction']
);
Route::get('/orders/view/{id}', [Orders::class, 'viewAction']);
Route::get('/invoices', [Invoices::class, 'indexAction']);
Route::get('/invoices/view/{id}', [Invoices::class, 'viewAction']);
Route::get('/invoices/new', [Invoices::class, 'newAction']);
Route::post('/invoices/generate', [Invoices::class, 'generateAction']);
