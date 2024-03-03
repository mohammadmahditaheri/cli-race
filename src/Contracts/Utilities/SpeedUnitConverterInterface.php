<?php

namespace App\Contracts\Utilities;

interface SpeedUnitConverterInterface
{
    /**
     * Convert speed of one unit to other
     *
     * @param float|int $speed The speed that is being converted in
     * @param string $fromUnit Unit of first unit to be converted from
     * @param string $toUnit Destination unit to be converted to
     *
     * @return int|float
     */
    public function convert(
        float|int $speed,
        string    $fromUnit,
        string    $toUnit,
    ): int|float;
}