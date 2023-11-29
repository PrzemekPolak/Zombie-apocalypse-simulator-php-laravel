<?php

use App\Presentation\Controller\Action\ClearSimulationAction;
use App\Presentation\Controller\Action\ExecuteTurnAction;
use App\Presentation\Controller\Action\RunWholeSimulationAction;
use App\Presentation\Controller\Action\SimulationSetupAction;
use App\Presentation\Http\Controllers\HumanController;
use App\Presentation\Http\Controllers\ZombieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/clearSimulation', ClearSimulationAction::class)->name('simulation.delete');
Route::get('human/randomList', [HumanController::class, 'getHumanRandomList']);
Route::get('zombie/randomList', [ZombieController::class, 'getZombieRandomList']);
Route::post('/simulation_turn', ExecuteTurnAction::class)->name('turn.create');
Route::post('/whole_simulation', RunWholeSimulationAction::class);
Route::post('/send_settings', SimulationSetupAction::class)->name('settings.update');
