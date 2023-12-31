<?php

namespace App\Presentation\Command;

use App\Application\SimulationSettings;
use App\Domain\Enum\SimulationSettingName;
use App\Domain\SimulationSetting;
use Illuminate\Console\Command;

class SetUpApplicationData extends Command
{
    public function __construct(
        private readonly SimulationSettings $simulationSettings,
    )
    {
        parent::__construct();
    }

    protected $signature = 'app:set-up-application-data';
    protected $description = 'SetUp Application Data';

    public function handle(): void
    {
        $this->simulationSettings->save($this->newSimulationSettings());

    }

    /** @return SimulationSetting[] */
    private function newSimulationSettings(): array
    {
        return array_map(
            fn(array $simulationSetting) => SimulationSetting::fromArray($simulationSetting),
            $this->simulationSettingsData()
        );
    }

    private function simulationSettingsData(): array
    {
        return [
            [
                'event' => SimulationSettingName::EncounterChance->value,
                'chance' => 40,
                'description' => 'Szansa, że dojdzie do walki z zombie',
            ],
            [
                'event' => SimulationSettingName::ChanceForBite->value,
                'chance' => 80,
                'description' => 'Podstawowa szansa, że człowiek zostanie ugryziony przez zombie podczas walki',
            ],
            [
                'event' => SimulationSettingName::InjuryChance->value,
                'chance' => 5,
                'description' => 'Szansa na przypadkowe zranienie się przez człowieka',
            ],
            [
                'event' => SimulationSettingName::ImmuneChance->value,
                'chance' => 10,
                'description' => 'Szansa że człowiek nie zostanie zarażony w przypadku ugryzienia',
            ],
        ];
    }
}
