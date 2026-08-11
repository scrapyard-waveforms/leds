<?php

namespace Waveforms\LEDs;

use GeneralPurposeIO\Core\MagicAliases\Circuit;
use Waveforms\Contracts\Actuation\Actuator as ActuatorContract;
use Waveforms\Contracts\Actuation\ActuatorException;
use Waveforms\Contracts\Actuation\Interfaces\LEDShape;
use Waveforms\PhysicalDevices\AbstractActuator;

class NeoPixel extends AbstractActuator implements ActuatorContract
{
    public function __construct(
        protected LEDShape $shape,
    ) {}

    public function pixelCount(): int
    {
        return $this->shape->pixelCount();
    }

    public function setPixelColor(
        int $pixel,
        int $color_or_red,
        ?int $green = null,
        ?int $blue = null,
        ?int $white = null,
    ): static {
        $this->shape->setPixelColor($pixel, $color_or_red, $green, $blue, $white);

        return $this;
    }

    public function getPixelColor(int $pixel): int
    {
        return $this->shape->getPixelColor($pixel);
    }

    public function fill(
        int $color_or_red,
        ?int $green = null,
        ?int $blue = null,
        ?int $white = null,
    ): static {
        $this->shape->fill($color_or_red, $green, $blue, $white);

        return $this;
    }

    public function clear(): static
    {
        $this->shape->clear();

        return $this;
    }

    public function brightness(float $brightness): static
    {
        $this->shape->setBrightness($brightness);

        return $this;
    }

    public function show(): static
    {
        $this->shape->show();

        return $this;
    }

    public function chase(
        int $color,
        int $cycles = 1,
        int $delay_us = 50_000,
    ): static {
        for ($cycle = 0; $cycle < $cycles; $cycle++) {
            for ($pixel = 0; $pixel < $this->pixelCount(); $pixel++) {
                $this->shape
                    ->clear()
                    ->setPixelColor($pixel, $color)
                    ->show();

                if ($delay_us > 0) {
                    usleep($delay_us);
                }
            }
        }

        return $this;
    }

    public static function circuit(string $driver): static
    {
        $circuit = Circuit::profile($driver);

        if ($circuit instanceof LEDShape) {
            return new static($circuit);
        }

        throw new ActuatorException("Circuit [{$driver}] is not an LEDShape.");
    }

    public function shape(): LEDShape
    {
        return $this->shape;
    }
}
