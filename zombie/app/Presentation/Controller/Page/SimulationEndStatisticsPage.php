<?php

namespace App\Presentation\Controller\Page;

use App\Presentation\Http\Controller;
use App\Presentation\View\SimulationEndStatisticsView;
use Illuminate\View\View;

class SimulationEndStatisticsPage extends Controller
{
    public function __construct(
        private readonly SimulationEndStatisticsView $simulationEndStatisticsView,
    )
    {
    }

    public function __invoke(): View
    {
        return view('simulation.end', $this->simulationEndStatisticsView->create());
    }
}
