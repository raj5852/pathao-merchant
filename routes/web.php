<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PathaoController;
use Illuminate\Support\Facades\Route;
use Xenon\MultiCourier\Courier;


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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('test',[PathaoController::class,'citys']);

Route::get('all-citys',[PathaoController::class,'citys']);
Route::get('get-zone/{cityid}',[PathaoController::class,'getZone']);
Route::get('arealists/{zone_id?}',[PathaoController::class,'arealist']);



Route::get('create-store',[PathaoController::class,'createStore']);
