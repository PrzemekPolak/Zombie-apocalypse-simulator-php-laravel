<?php

namespace App\Presentation\Controller\Page;

use App\Http\Controllers\Controller;
use App\Presentation\View\SimulationSettingsView;
use Illuminate\View\View;

class SimulationSettingsPage extends Controller
{
    public function __construct(
        private readonly SimulationSettingsView $simulationSettingsView,
    )
    {
    }

    public function __invoke(): View
    {
        return view('simulation.settings', $this->simulationSettingsView->create());
    }
}
