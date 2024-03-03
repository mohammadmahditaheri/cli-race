<?php

namespace App\Utilities;

use App\Contracts\Utilities\CommandLineInterface;

class CommandLine implements CommandLineInterface
{
    /**
     * @inheritDoc
     */
    public function presentOutput(string $output): void
    {
        echo $output;
    }

    /**
     * @inheritDoc
     */
    public function getInput(string $prompt): string|false
    {
        return readline($prompt);
    }
}