<?php

use App\Http\Controllers\HumanController;
use App\Http\Controllers\SimulationSettingController;
use App\Http\Controllers\ZombieController;
use App\Presentation\Controller\Action\ExecuteTurnAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('clearSimulation', [SimulationSettingController::class, 'clearSimulation'])->name('simulation.delete');
Route::get('human/randomList', [HumanController::class, 'getHumanRandomList']);
Route::get('zombie/randomList', [ZombieController::class, 'getZombieRandomList']);
Route::post('/simulation_turn', ExecuteTurnAction::class)->name('turn.create');
