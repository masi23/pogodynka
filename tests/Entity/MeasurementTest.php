<?php

namespace App\Tests\Entity;

use App\Entity\Forecast;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider; 

class MeasurementTest extends TestCase
{
    public static function dataGetFahrenheit(): array
    {
        return [
            ['0', '32'],
            ['-100', '-148'],
            ['100', '212'],
            ['0.5', '32.9'],
            ['-0.5', '31.1'],
            ['10', '50'],
            ['20.5', '68.9'],
            ['36.5', '97.7'],
            ['-10.5', '13.1'],
            ['25.5', '77.9'],
        ];
    }

    #[DataProvider('dataGetFahrenheit')]
    public function testGetFahrenheit(
        string $celsius,
        string $expectedFahrenheit
    ): void {
        $forecast = new Forecast();
        $forecast->setTemperature($celsius);

        $this->assertEqualsWithDelta(
            $expectedFahrenheit,
            $forecast->getFahrenheit(),
            0.0001
        );
    }


}
