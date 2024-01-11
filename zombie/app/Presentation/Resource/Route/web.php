<?php

use App\Presentation\Controller\Page\SimulationDashboardPage;
use App\Presentation\Controller\Page\SimulationEndStatisticsPage;
use App\Presentation\Controller\Page\SimulationSettingsPage;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->redirectTo('/settings');
});
Route::get('/dashboard', SimulationDashboardPage::class)->name('dashboard');
Route::get('/settings', SimulationSettingsPage::class)->name('settings');
Route::get('/statistics', SimulationEndStatisticsPage::class);
