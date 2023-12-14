<?php

namespace SimulationTurnService;

use App\Application\Service\TurnActions\ZombieEncounters;
use App\Domain\HumanBite;
use App\Services\ProbabilityService;
use App\Tests\MyTestCase;

class ZombieEncountersTest extends MyTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->system()->hasResources(
            aResource()->withType('weapon')->withQuantity(100)->build(),
        );
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->withTurnNumber(1)->build(),
        );
    }

    /** @test */
    public function zombieAlwaysGetsKilledWhenItFailsToBiteHuman(): void
    {
        $this->system()->hasSimulationSettings(
            aSimulationSetting()->withEvent('chanceForBite')->withChance(0)->build(),
            aSimulationSetting()->withEvent('encounterChance')->withChance(100)->build(),
            aSimulationSetting()->withEvent('immuneChance')->withChance(0)->build(),
        );
        $this->systemHasHumansAndZombies();

        $this->zombieEncounters();

        assertThat($this->allZombiesAreDead(), is(equalTo(true)));
    }

    /** @test */
    public function humanAlwaysGetsBittenWhenChanceForBiteIsCertain(): void
    {
        $this->system()->hasSimulationSettings(
            aSimulationSetting()->withEvent('chanceForBite')->withChance(200)->build(),
            aSimulationSetting()->withEvent('encounterChance')->withChance(100)->build(),
            aSimulationSetting()->withEvent('immuneChance')->withChance(0)->build(),
        );
        $this->systemHasHumansAndZombies();

        $this->zombieEncounters();

        assertThat($this->allHumansAreInfected(), is(equalTo(true)));
    }

    /** @test */
    public function humanBitesAreRecordedCorrectly(): void
    {
        $turn = 2;
        $human = aHuman()->build();
        $zombie = aZombie()->build();
        $expectedHumanBite = new HumanBite(
            $human->id,
            $zombie->id,
            $turn
        );

        $this->system()->hasSimulationSettings(
            aSimulationSetting()->withEvent('chanceForBite')->withChance(200)->build(),
            aSimulationSetting()->withEvent('encounterChance')->withChance(100)->build(),
            aSimulationSetting()->withEvent('immuneChance')->withChance(0)->build(),
        );
        $this->system()->hasSimulationTurns(
            aSimulationTurn()->withTurnNumber($turn)->build(),
        );
        $this->system()->hasHumans(
            $human,
        );
        $this->system()->hasZombies(
            $zombie,
        );

        $this->zombieEncounters();

        assertThat($this->humanBiteFromTurn($turn), is(equalTo($expectedHumanBite)));
    }

    /** @test */
    public function immuneHumansDontGetInfected(): void
    {
        $this->system()->hasSimulationSettings(
            aSimulationSetting()->withEvent('chanceForBite')->withChance(200)->build(),
            aSimulationSetting()->withEvent('encounterChance')->withChance(100)->build(),
            aSimulationSetting()->withEvent('immuneChance')->withChance(100)->build(),
        );
        $this->systemHasHumansAndZombies();

        $this->zombieEncounters();

        assertThat($this->allHumansAreInfected(), is(equalTo(false)));
    }

    private function zombieEncounters(): void
    {
        (new ZombieEncounters(
            $this->system()->humans(),
            $this->system()->resources(),
            $this->system()->simulationTurns(),
            $this->system()->simulationSettings(),
            $this->system()->humanInjuries(),
            $this->system()->humanBites(),
            $this->system()->zombies(),
            new ProbabilityService(),
        ))->execute();
    }

    private function allZombiesAreDead(): bool
    {
        foreach ($this->system()->zombies()->all() as $zombie) {
            if ('dead' !== $zombie->health) {
                return false;
            }
        }
        return true;
    }

    private function allHumansAreInfected(): bool
    {
        foreach ($this->system()->humans()->all() as $human) {
            if ('infected' !== $human->health) {
                return false;
            }
        }
        return true;
    }

    private function humanBiteFromTurn(int $turn): HumanBite
    {
        return $this->system()->humanBites()->fromTurn($turn)[0];
    }

    private function systemHasHumansAndZombies(): void
    {
        $this->system()->hasHumans(
            aHuman()->build(),
            aHuman()->build(),
        );
        $this->system()->hasZombies(
            aZombie()->build(),
            aZombie()->build(),
        );
    }
}
