<?php

namespace App\Contracts\Utilities;

interface JsonHandlerInterface
{
    /**
     * Load vehicles from json file and decode its content
     *
     * @return array
     */
    public function loadVehiclesFromJsonFile(): array;
}