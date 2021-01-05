<?php

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

Route::get('/', 'StockController@index')->name('stocks.index');
Route::post('stocks', 'StockController@store')->name('stocks.store');
Route::put('stocks/{id}', 'StockController@update')->name('stocks.update');
Route::delete('stocks/{id}', 'StockController@destroy')->name('stocks.destroy');
