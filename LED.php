<?php

namespace Waveforms\LEDs;

use GeneralPurposeIO\Core\MagicAliases\Circuit;
use Waveforms\Contracts\Actuation\Actuator as ActuatorContract;
use Waveforms\Contracts\Actuation\ActuatorException;
use Waveforms\Contracts\Actuation\Interfaces\LED as LEDCircuit;
use Waveforms\PhysicalDevices\AbstractActuator;

class LED extends AbstractActuator implements ActuatorContract
{
    public function __construct(
        protected LEDCircuit $led,
    ) {}

    public function on(): void
    {
        $this->led->on();
    }

    public function off(): void
    {
        $this->led->off();
    }

    public function toggle(): void
    {
        $this->led->toggle();
    }

    public function isOn(): bool
    {
        return $this->led->isOn();
    }

    public function brightness(?int $percent = null): int
    {
        return $this->led->brightness($percent);
    }

    public static function circuit(string $driver): static
    {
        $circuit = Circuit::profile($driver);

        if ($circuit instanceof LEDCircuit) {
            return new static($circuit);
        }

        throw new ActuatorException("Circuit [{$driver}] is not an LED.");
    }
}
