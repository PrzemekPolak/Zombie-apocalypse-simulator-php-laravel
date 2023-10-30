<?php

namespace App\Infrastructure;

use App\Application\SimulationTurns;
use App\Models\SimulationTurn;
use App\Domain\SimulationTurn as DomainSimulationTurn;
use Illuminate\Support\Facades\DB;

class SqlSimulationTurns implements SimulationTurns
{
    public function currentTurn(): int
    {
        return SimulationTurn::currentTurn();
    }

    public function createNewTurn(string $status = 'active'): void
    {
        SimulationTurn::createNewTurn();
    }

    public function add(DomainSimulationTurn $simulationTurn): void
    {
        $turn = new SimulationTurn();
        $turn->id = $simulationTurn->turnNumber;
        $turn->status = $simulationTurn->status;
        $turn->save();
    }

    public function save(array $simulationTurns): void
    {
        DB::transaction(function () use ($simulationTurns) {
            foreach ($simulationTurns as $simulationTurn) {
                SimulationTurn::updateOrCreate(
                    [
                        'id' => $simulationTurn->turnNumber
                    ],
                    [
                        'status' => $simulationTurn->status,
                    ]
                );
            }
        });
    }

    public function all(): array
    {
        return $this->mapToDomainSimulationTurnsArray(SimulationTurn::all()->toArray());
    }

    /** @return DomainSimulationTurn[] */
    private function mapToDomainSimulationTurnsArray(array $dbArray): array
    {
        return array_map(static function ($simulationTurn) {
            return DomainSimulationTurn::fromArray($simulationTurn);
        }, $dbArray);
    }
}
