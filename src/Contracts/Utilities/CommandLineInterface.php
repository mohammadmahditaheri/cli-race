<?php

namespace App\Contracts\Utilities;

interface CommandLineInterface
{

    /**
     * Present output on the terminal(cli)
     *
     * @param string $output
     * @return void
     */
    public function presentOutput(string $output): void;

    /**
     * Receive the user input via terminal(cli)
     *
     * @param string $prompt
     * @return string|false
     */
    public function getInput(string $prompt): string|false;
}