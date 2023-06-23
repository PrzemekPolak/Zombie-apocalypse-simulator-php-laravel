<?php

use App\Http\Controllers\SimulationSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimulationTurnController;

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

Route::get('/', function () {
    return response()->redirectTo('/settings');
});
Route::get('/dashboard', [SimulationTurnController::class, 'index'])->name('dashboard');;
Route::post('/simulation_turn', [SimulationTurnController::class, 'store'])->name('turn.create');
Route::get('/settings', [SimulationSettingController::class, 'index'])->name('settings');
Route::post('/send_settings', [SimulationSettingController::class, 'store'])->name('settings.update');
Route::get('/statistics', [SimulationTurnController::class, 'getStatisticsView']);
