<?php

namespace App;

/**
 * This class represents the game and handles
 * its overall flow.
 */
class Game
{
    public function __construct(
        private CommandLine $commandLine
    )
    {
    }

    /**
     * Runs the game by executing its different stages.
     */
    public function run()
    {
        // welcome
        $this->commandLine->displayWelcomeMessage();

        // load vehicles
        $vehicles = $this->loadVehicles();

        // players
        $players = $this->selectVehicles($vehicles);

        // race
        $race = new Race($players);
        $race->run();

        // results
        $this->displayResults($race);
    }
}