<?php

namespace App\Infrastructure;

use App\Application\SimulationTurns;
use App\Models\SimulationTurn as ModelSimulationTurn;
use App\Domain\SimulationTurn;
use Illuminate\Support\Facades\DB;

class SqlSimulationTurns implements SimulationTurns
{
    public function currentTurn(): int
    {
        return ModelSimulationTurn::currentTurn();
    }

    public function createNewTurn(string $status = 'active'): void
    {
        ModelSimulationTurn::createNewTurn();
    }

    public function save(array $simulationTurns): void
    {
        DB::transaction(function () use ($simulationTurns) {
            foreach ($simulationTurns as $simulationTurn) {
                ModelSimulationTurn::updateOrCreate(
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
        return $this->mapToDomainSimulationTurnsArray(ModelSimulationTurn::all()->toArray());
    }

    public function removeAll(): void
    {
        ModelSimulationTurn::truncate();
    }

    /** @return SimulationTurn[] */
    private function mapToDomainSimulationTurnsArray(array $dbArray): array
    {
        return array_map(static function ($simulationTurn) {
            return SimulationTurn::fromArray($simulationTurn);
        }, $dbArray);
    }
}
