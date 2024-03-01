<?php

namespace App;

/**
 * This class represents a vehicle with its properties
 */
class Vehicle
{
    public function __construct(
        private string $name,
        private int $maxSpeed,
        private int $unit
    )
    {
    }

    /**
     * ---------------------------------------------------
     * --------------------  Getters ---------------------
     * ---------------------------------------------------
     */

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxSpeed(): int
    {
        return $this->maxSpeed;
    }

    public function getUnit(): int
    {
        return $this->unit;
    }
}