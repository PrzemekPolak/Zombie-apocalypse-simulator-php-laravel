<?php

namespace App\Presentation\Controller\Page;

use App\Presentation\Http\Controller;
use App\Presentation\View\DashboardView;
use Illuminate\View\View;

class SimulationDashboardPage extends Controller
{
    public function __construct(
        private readonly DashboardView $dashboardView,
    )
    {
    }

    public function __invoke(): View
    {
        return view('simulation.dashboard', $this->dashboardView->create());
    }
}
