<?php

namespace App\Data\DTOs;

class PlayerDTO
{
    private int|float $timeToFinish;
    public function __construct(
        private int $playerNo,
        private VehicleDTO $vehicle
    )
    {
    }

    public function setVehicle(VehicleDTO $vehicle): PlayerDTO
    {
        $this->vehicle = $vehicle;
        return $this;
    }

    public function setTime(int|float $time): PlayerDTO
    {
        $this->timeToFinish = $time;
        return $this;
    }

    public function setPlayerNo(int $playerNo): PlayerDTO
    {
        $this->playerNo = $playerNo;
        return $this;
    }

    public function getName(): string
    {
        return "Player No. $this->playerNo";
    }

    public function getVehicle(): VehicleDTO
    {
        return $this->vehicle;
    }

    public function getMaxSpeed(): float
    {
        return $this->vehicle->getMaxSpeed();
    }

    public function getTimeToFinish(): float|int
    {
        return $this->timeToFinish;
    }
}