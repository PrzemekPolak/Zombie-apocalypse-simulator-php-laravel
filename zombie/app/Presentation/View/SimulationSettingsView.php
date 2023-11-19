<?php

namespace App\Presentation\View;

use App\Application\SimulationSettings;
use App\Application\SimulationTurns;
use App\Http\Requests\StartSimulationRequest;

class SimulationSettingsView
{
    public function __construct(
        private readonly SimulationSettings $simulationSettings,
        private readonly SimulationTurns    $simulationTurns,
    )
    {
    }

    public function create(): array
    {
        return [
            'settings' => $this->simulationSettings->all(),
            'rules' => $this->prepareRulesForFrontend(),
            'simulationOngoing' => false === empty($this->simulationTurns->all()),
        ];
    }

    private function prepareRulesForFrontend(): array
    {
        $result = [];
        $rulesFromRequest = (new StartSimulationRequest())->rules();
        foreach ($rulesFromRequest as $key => $value) {
            $result[$key] = explode('|', str_replace('required|', '', $value));
            $result[$key][0] = (int)str_replace('min:', '', $result[$key][0]);
            $result[$key][1] = (int)str_replace('max:', '', $result[$key][1]);
        }

        return $result;
    }
}
