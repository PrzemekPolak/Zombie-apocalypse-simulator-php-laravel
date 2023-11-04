<?php

namespace App\Infrastructure;

use App\Application\SimulationSettings;
use App\Domain\SimulationSetting;
use App\Models\SimulationSetting as ModelSimulationSetting;
use Illuminate\Support\Facades\DB;

class SqlSimulationSettings implements SimulationSettings
{

    public function getEventChance(string $eventName): int
    {
        return ModelSimulationSetting::getEventChance($eventName);
    }

    public function save(array $simulationSettings): void
    {
        DB::transaction(function () use ($simulationSettings) {
            foreach ($simulationSettings as $simulationSetting) {
                ModelSimulationSetting::updateOrCreate(
                    [
                        'event' => $simulationSetting->event
                    ],
                    [
                        'event' => $simulationSetting->event,
                        'chance' => $simulationSetting->chance,
                        'description' => $simulationSetting->description,
                    ]
                );
            }
        });
    }

    public function all(): array
    {
        return $this->mapToDomainSimulationSettingsArray(ModelSimulationSetting::all()->toArray());
    }

    /** @return SimulationSetting[] */
    private function mapToDomainSimulationSettingsArray(array $dbArray): array
    {
        return array_map(static function ($simulationSetting) {
            return SimulationSetting::fromArray($simulationSetting);
        }, $dbArray);
    }
}
