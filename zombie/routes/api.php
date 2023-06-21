<?php

use App\Http\Controllers\HumanController;
use App\Http\Controllers\SimulationSettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('clearSimulation', [SimulationSettingController::class, 'clearSimulation'])->name('simulation.delete');
Route::get('human/professions', [HumanController::class, 'getHumansCountByProfession']);
