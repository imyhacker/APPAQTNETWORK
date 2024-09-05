<?php

use App\Http\Controllers\DepanController;
use App\Http\Controllers\IPController;
use App\Http\Controllers\MKController;
use App\Http\Controllers\OLTController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DepanController::class, 'index'])->name('indexdepan');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// VPN
Route::group(['prefix' => '/home/datavpn'], function() {
    Route::get('/', [VPNController::class, 'index'])->name('datavpn');
    Route::post('/uploadvpn', [VPNController::class, 'uploadvpn'])->name('uploadvpn');
    Route::delete('/{id}', [VPNController::class, 'hapusvpn'])->name('hapusvpn');
});


// MIKROTIK
Route::group(['prefix' => '/home/datamikrotik'], function(){
    Route::get('/', [MKController::class, 'index'])->name('datamikrotik');
    Route::post('/tambahmikrotik', [MKController::class, 'tambahmikrotik'])->name('tambahmikrotik');
    Route::get('/aksesmikrotik', [MKController::class, 'aksesMikrotik'])->name('aksesmikrotik');

    Route::get('/masukmikrotik', [MKController::class, 'masukmikrotik'])->name('masukmikrotik');
    Route::post('/add-firewall-rule', [MKController::class, 'addFirewallRule'])->name('addFirewallRule');
    Route::post('/restartmodem', [MKController::class, 'restartmodem'])->name('restartmodem');

    Route::get('/edit/{id}', [MKController::class, 'edit'])->name('mikrotik.edit');
    Route::post('/{id}/update', [MKController::class, 'update'])->name('mikrotik.update');

    Route::delete('/delete/{id}', [MKController::class, 'destroy'])->name('mikrotik.delete');
});



// OLT
Route::group(['prefix' => '/home/dataolt'], function(){
    Route::get('/', [OLTController::class, 'index'])->name('dataolt');
    Route::post('/tambaholt', [OLTController::class, 'tambaholt'])->name('tambaholt');
    Route::get('/aksesolt', [OLTController::class, 'aksesOLT'])->name('aksesolt');
    Route::get('/{id}/hapusolt', [OLTController::class, 'hapusolt'])->name('hapusolt');
});

Route::group(['prefix' => '/home/dataip'], function(){
    Route::get('/nighbore', [IPController::class, 'nighbore'])->name('nighbore');
    Route::get('/aksesnightbore', [IPController::class, 'aksesnightbore'])->name('aksesnightbore');

});