<?php

use App\Http\Controllers\FrontEndController;
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

// Route::get('/', function () {
//     return view('front.index');
// });

Route::get('/', [FrontEndController::class, 'index'])->name('front.index');
Route::get('/search', [FrontEndController::class, 'search'])->name('front.search');
