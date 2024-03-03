<?php

namespace App\Contracts\Repositories;

use Data\DTOs\VehicleDTO;

interface VehicleRepositoryInterface
{
    /**
     * @return array|VehicleDTO[]
     */
    public function getVehicles(): array;
}