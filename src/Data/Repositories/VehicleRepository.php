<?php

namespace App\Data\Repositories;

use App\Contracts\Repositories\VehicleRepositoryInterface;
use App\Contracts\Utilities\JsonHandlerInterface;
use App\Contracts\Utilities\SpeedUnitConverterInterface;
use App\Enums\UnitsEnum;
use App\Data\DTOs\VehicleDTO;

class VehicleRepository implements VehicleRepositoryInterface
{
    private array $allowedParams = [
        'name',
        'maxSpeed',
        'unit'
    ];
    public function __construct(
        private JsonHandlerInterface $jsonHandler,
        private SpeedUnitConverterInterface $speedConverter
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function getVehicles(): array
    {
        $vehicles = [];
        foreach ($this->jsonHandler->loadVehiclesFromJsonFile() as $vehicleData) {
            $vehicles[] = $this->initVehicle($vehicleData);
        }

        return $vehicles;
    }

    public function speedInKmPerHour(VehicleDTO $vehicleDTO)
    {
        return $this->speedConverter->convert(
            $vehicleDTO->getMaxSpeed(),
            $vehicleDTO->getUnit(),
            UnitsEnum::KM_PER_HOUR
        );
    }

    private function initVehicle(array $vehicleData): VehicleDTO|null
    {
        if (!$this->paramsMatch($vehicleData)) {
            return null; // if nonsense params are passed
        }

        // speed is converted to km/h and all maxSpeeds are normalized
        $this->normalizeSpeed($vehicleData);

        return new VehicleDTO(...$vehicleData);
    }

    private function paramsMatch(array $vehicleData): bool
    {
        return (count($this->allowedParams) === count(array_keys($vehicleData))) &&
            empty(array_diff($this->allowedParams, array_keys($vehicleData)));
    }

    private function normalizeSpeed(array &$vehicleData): void
    {
        $vehicleData['maxSpeed'] = $this->speedConverter->convert(
            $vehicleData['maxSpeed'],
            $vehicleData['unit'],
            UnitsEnum::KM_PER_HOUR
        );

        $vehicleData['unit'] = UnitsEnum::KM_PER_HOUR;
    }
}