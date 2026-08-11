<?php

namespace Waveforms\LEDs;

use Fabricate\NutsAndBolts\ServiceProvider;
use Waveforms\Core\MagicAliases\Actuator;

class LEDsServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        if (config('waveforms.led.enabled', false)) {
            Actuator::addActuator('led', LED::class);
        }

        if (config('waveforms.neopixel.enabled', false)) {
            Actuator::addActuator('neopixel', NeoPixel::class);
        }
    }
}
