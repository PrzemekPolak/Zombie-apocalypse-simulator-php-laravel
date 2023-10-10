<?php

namespace App\Tests\TestUtils\Builders;

use App\Domain\SimulationSetting;

class SimulationSettingBuilder
{
    public function __construct(
        public string $event,
        public int    $chance,
        public string $description,
    )
    {
    }

    public static function default(): self
    {
        return new self(
            'injuryChance',
            100,
            'Default description',
        );
    }

    public function withEvent(string $event): self
    {
        return new self(
            $event,
            $this->chance,
            $this->description,
        );
    }

    public function withChance(int $chance): self
    {
        return new self(
            $this->event,
            $chance,
            $this->description,
        );
    }

    public function build(): SimulationSetting
    {
        return new SimulationSetting(
            $this->event,
            $this->chance,
            $this->description,
        );
    }
}
