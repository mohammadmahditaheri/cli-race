<?php

namespace Tests\Unit\Data\DTOs;

use TypeError;
use App\Enums\UnitsEnum;
use App\Data\DTOs\PlayerDTO;
use App\Data\DTOs\VehicleDTO;
use PHPUnit\Framework\TestCase;

class PlayerDTOTest extends TestCase
{
    public function test_that_it_can_be_created()
    {
        $playerDTO = new PlayerDTO(
            playerNo: 1,
            vehicle: new VehicleDTO(
                name: 'Car',
                maxSpeed: 200,
                unit: UnitsEnum::KM_PER_HOUR
            )
        );

        expect($playerDTO)->toBeInstanceOf(PlayerDTO::class);
    }

    public function test_that_it_can_set_and_get_vehicle()
    {
        $vehicle = new VehicleDTO(
            name: 'Bike',
            maxSpeed: 50,
            unit: UnitsEnum::KM_PER_HOUR
        );

        $playerDTO = new PlayerDTO(
            playerNo: 1,
            vehicle: new VehicleDTO(
                name: 'Car',
                maxSpeed: 200,
                unit: UnitsEnum::KM_PER_HOUR
            )
        );

        $playerDTO->setVehicle($vehicle);

        expect($playerDTO->getVehicle())->toBeInstanceOf(VehicleDTO::class);
        expect($playerDTO->getVehicle()->getName())->toBe('Bike');
        expect($playerDTO->getVehicle()->getMaxSpeed())->toBe(50);
        expect($playerDTO->getVehicle()->getUnit())->toBe(UnitsEnum::KM_PER_HOUR);
    }

    public function test_that_it_can_set_and_get_time_to_finish()
    {
        $playerDTO = new PlayerDTO(
            playerNo: 1,
            vehicle: new VehicleDTO(
                name: 'Car',
                maxSpeed: 200,
                unit: UnitsEnum::KM_PER_HOUR
            )
        );

        $playerDTO->setTime(120.5);

        expect($playerDTO->getTimeToFinish())->toBe(120.5);
    }

    public function test_that_it_can_set_and_get_player_no()
    {
        $playerDTO = new PlayerDTO(
            playerNo: 1,
            vehicle: new VehicleDTO(
                name: 'Car',
                maxSpeed: 200,
                unit: UnitsEnum::KM_PER_HOUR
            )
        );

        $playerDTO->setPlayerNo(2);

        expect($playerDTO->getName())->toBe('Player No. 2');
    }
}