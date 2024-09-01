<?php

namespace Tests\Unit\Data\DTOs;

use App\Enums\UnitsEnum;
use App\Data\DTOs\VehicleDTO;
use PHPUnit\Framework\TestCase;

class VehicleDTOTest extends TestCase
{
    public function test_that_it_can_be_created()
    {
        $vehicleDTO = new VehicleDTO(
            name: 'Car',
            maxSpeed: 200,
            unit: UnitsEnum::KM_PER_HOUR
        );

        expect($vehicleDTO)->toBeInstanceOf(VehicleDTO::class);
    }
}