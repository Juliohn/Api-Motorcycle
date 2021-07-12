<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('/motorcycles', 'Api\\MotorcyclesController');
Route::resource('/stock-motorcycles', 'Api\\StockMotorcyclesController');
Route::get('/list-stock-motorcycle/{motorcycle_id}', 'Api\\StockMotorcyclesController@listFromMotorcycle');
