<?php

use App\Http\Controllers\SimulationSettingController;
use App\Presentation\Controller\Page\SimulationDashboardPage;
use App\Presentation\Controller\Page\SimulationEndStatisticsPage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->redirectTo('/settings');
});
Route::get('/dashboard', SimulationDashboardPage::class)->name('dashboard');
Route::get('/settings', [SimulationSettingController::class, 'index'])->name('settings');
Route::post('/send_settings', [SimulationSettingController::class, 'store'])->name('settings.update');
Route::get('/statistics', SimulationEndStatisticsPage::class);
