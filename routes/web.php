<?php

use App\Http\Controllers\VPNController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => '/home/datavpn'], function() {
   Route::get('/', [VPNController::class, 'index'])->name('datavpn');
   Route::post('/uploadvpn', [VPNController::class, 'uploadvpn'])->name('uploadvpn');
    // Rute lainnya yang memiliki prefix 'admin'

    Route::delete('/{id}', [VPNController::class, 'hapusvpn'])->name('hapusvpn');

});