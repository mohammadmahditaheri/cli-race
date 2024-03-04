<?php

namespace App\Utilities;

use App\Contracts\Utilities\SpeedUnitConverterInterface;
use App\Enums\UnitsEnum;
use InvalidArgumentException;

class SpeedUnitConverter implements SpeedUnitConverterInterface
{
    public const SAME = 1;

    /**
     * Error messages
     */
    private const UNSUPPORTED_CONVERSION_MESSAGE = 'Unsupported conversion error';
    private const UNSUPPORTED_UNITS = 'Unsupported units.';

    private array $conversionMultiplier = [
        // from
        UnitsEnum::KM_PER_HOUR => [
            // to
            UnitsEnum::KNOTS => 0.53996 /* multiplier factor */,
            UnitsEnum::KM_PER_HOUR => self::SAME
        ],

        UnitsEnum::KNOTS => [
            UnitsEnum::KNOTS => self::SAME,
            UnitsEnum::KM_PER_HOUR => 1.852,
        ]
    ];

    /**
     * Alias mappings
     * @var array
     */
    private array $aliases = [
        // knots
        'knots' => UnitsEnum::KNOTS,
        'Knots' => UnitsEnum::KNOTS,
        'kts' => UnitsEnum::KNOTS,
        'Kts' => UnitsEnum::KNOTS,

        // kmh
        'kmh' => UnitsEnum::KM_PER_HOUR,
        'Kmh' => UnitsEnum::KM_PER_HOUR,
        'km/h' => UnitsEnum::KM_PER_HOUR,
        'Km/h' => UnitsEnum::KM_PER_HOUR,
    ];

    /**
     * @inheritDoc
     */
    public function convert(
        float|int $speed,
        string    $fromUnit,
        string    $toUnit,
    ): int|float
    {
        // casing normalization
        $fromUnit = $this->normalizeUnit($fromUnit);
        $toUnit = $this->normalizeUnit($toUnit);

        // to alias
        $fromUnit = $this->toAlias($fromUnit);
        $toUnit = $this->toAlias($toUnit);

        if (!isset($this->conversionMultiplier[$fromUnit][$toUnit])) {
            throw $this->unsupportedConversionError();
        }
        return $this->conversionMultiplier[$fromUnit][$toUnit] * $speed;
    }

    /**
     * Map to unique alias for different possible writings
     *
     * @param string $unit
     * @return string
     */
    private function toAlias(string $unit): string
    {
        if (!isset($this->aliases[$unit])) {
            throw $this->unsupportedUnitsError();
        }

        return $this->aliases[$unit];
    }

    private function normalizeUnit(string $unit): string
    {
        return strtolower($unit);
    }

    /**
     * ------------------- Errors --------------------
     */

    /**
     * Throws Unsupported conversion between units error
     */
    private function unsupportedConversionError()
    {
        throw new InvalidArgumentException(
            self::UNSUPPORTED_CONVERSION_MESSAGE
        );
    }

    /**
     * Throws unsupported units error
     */
    public function unsupportedUnitsError(): InvalidArgumentException
    {
        throw new InvalidArgumentException(self::UNSUPPORTED_UNITS);
    }
}