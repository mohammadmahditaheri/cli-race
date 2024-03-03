<?php

namespace App\Utilities;

use App\Contracts\Utilities\JsonHandlerInterface;

class JsonHandler implements JsonHandlerInterface
{
    public const FILE_ADDRESS = __DIR__. '/../../vehicles.json';

    /**
     * @inheritDoc
     */
    public function loadVehiclesFromJsonFile(): array
    {
        return json_decode($this->readFile(), true);
    }

    private function readFile(): false|string
    {
        return file_get_contents(self::FILE_ADDRESS, true);
    }
}