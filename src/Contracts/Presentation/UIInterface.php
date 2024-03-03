<?php

namespace App\Contracts\Presentation;

use App\Data\DTOs\VehicleDTO;

interface UIInterface
{
    /**
     * Delivers the output (as string) vie the user interface
     *
     * @param string $output
     * @return void
     */
    public function presentOutput(string $output): void;

    /**
     * Receives the user input via the user interface
     *
     * @param string $prompt
     * @return string|false
     */
    public function getInput(string $prompt): string|false;

    public function displayWelcome(): void;

    /**
     * Display the list of available vehicles for the race
     *
     * @param VehicleDTO[] $vehicles Array of vehicle objects
     * @return void
     */
    public function displayVehicleList(array $vehicles): void;

    /**
     * Gets the player's vehicle choice input
     *
     * @param int $playerNumber The player number (used for prompting)
     * @param VehicleDTO[] $vehicles
     * @return VehicleDTO The chosen vehicle
     */
    public function getPlayerVehicleChoice(
        int   $playerNumber,
        array $vehicles // Vehicle[]
    ): VehicleDTO;

    /**
     *  Displays the winner of the race.
     *
     * @param string $winner The name of the player with winning vehicle.
     * @return void
     */
    public function displayWinner(
        string $winner
    ): void;

    /**
     * Displays the completion times for all vehicles.
     *
     * @param array $raceTimes An associative array with vehicle names as keys and race times as values.
     */
    public function displayRaceTimes(array $raceTimes): void;

    /**
     * Shows the race as if it is running
     *
     * @return void
     */
    public function displayRaceIsRunning(): void;
}