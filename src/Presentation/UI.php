<?php

namespace App\Presentation;

use App\Contracts\Presentation\UIInterface;
use App\Contracts\Utilities\CommandLineInterface;
use App\Data\DTOs\VehicleDTO;
use App\Utilities\CommandLine;

class UI implements UIInterface
{
    private const WELCOME_MESSAGE = 'Welcome to the CLI Racing Game!' . PHP_EOL;
    private const VEHICLE_LIST_TITLE = '** Choose your vehicle: **' . PHP_EOL;

    private const RACE_STARTED = PHP_EOL . 'Race is started! >>>' . PHP_EOL;
    private const RACE_IS_RUNNING = PHP_EOL . '>>> Race is running! >>>' . PHP_EOL;
    private const RACE_FINISHED = PHP_EOL . '>>> Race is finished!' . PHP_EOL;

    private CommandLineInterface $cliUtility;

    public function __construct()
    {
        $this->initCliUtility();
    }

    /**
     * @inheritDoc
     */
    public function presentOutput(string $output): void
    {
        $this->cliUtility->presentOutput($output);
    }

    /**
     * @inheritDoc
     */
    public function getInput(string $prompt): string|false
    {
        return $this->cliUtility->getInput($prompt);
    }

    public function displayWelcome(): void
    {
        $this->presentOutput(self::WELCOME_MESSAGE);
    }

    /**
     * Display the list of available vehicles for the race
     *
     * @param VehicleDTO[] $vehicles Array of vehicle objects
     * @return void
     */
    public function displayVehicleList(array $vehicles): void
    {
        // title
        $this->presentOutput(self::VEHICLE_LIST_TITLE);

        // show each vehicle
        for ($i = 0; $i < count($vehicles); $i++) {
            $this->presentOutput($this->formatSingleVehicle($i, $vehicles[$i]));
        }
    }

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
    ): VehicleDTO
    {
        while (true) {
            $this->displayVehicleList($vehicles);

            $choice = $this->getInput(
                $this->formatChooseVehiclePrompt(
                    $playerNumber,
                    count($vehicles)
                )
            );

            if ($this->choiceIsValid($choice, count($vehicles))) {
                return $vehicles[((int)$choice) - 1];
            } else {
                $this->presentOutput(
                    $this->formatErroneousChoice(count($vehicles))
                );
            }
        }
    }

    /**
     *  Displays the winner of the race.
     *
     * @param string $winner The name of the player with winning vehicle.
     * @return void
     */
    public function displayWinner(
        string $winner
    ): void
    {
        $this->presentOutput(
            sprintf(
                "%s** And the winner is: %s! **%s",
                PHP_EOL,
                $winner,
                PHP_EOL
            )
        );
    }

    /**
     * Displays the completion times for all vehicles.
     *
     * @param array $raceTimes An associative array with vehicle names as keys and race times as values.
     */
    public function displayRaceTimes(array $raceTimes): void
    {
        $this->presentOutput($this->formatRaceTimesTitle());

        foreach ($raceTimes as $name => $time) {
            $this->presentOutput($this->formatRaceTime($name, $time));
        }
    }

    /**
     * @inheritDoc
     */
    public function displayRaceIsRunning(): void
    {
        $this->presentOutput(self::RACE_STARTED);
        $this->presentOutput(self::RACE_IS_RUNNING);
        sleep(1);
        $this->presentOutput(self::RACE_FINISHED);
    }

    /**
     * ---------------- Private -------------------
     */

    private function initCliUtility(): void
    {
        $this->cliUtility = new CommandLine();
    }

    /**
     * Format the presentation of each vehicle data
     *
     * @param int $i
     * @param VehicleDTO $vehicle
     * @return string
     */
    private function formatSingleVehicle(
        int        $i,
        VehicleDTO $vehicle
    ): string
    {
        return sprintf(
            "%d. %s (%s %s)%s",
            $i + 1,
            $vehicle->getName(),
            $vehicle->getMaxSpeed(),
            $vehicle->getUnit(),
            PHP_EOL
        );
    }

    /**
     * Formats vehicle choose prompt
     *
     * @param int $playerNumber
     * @param int $vehiclesCount
     * @return string
     */
    private function formatChooseVehiclePrompt(
        int $playerNumber,
        int $vehiclesCount
    ): string
    {
        return PHP_EOL . sprintf(
            "Player $playerNumber, choose your vehicle (1-%d): ",
            $vehiclesCount
        );
    }

    private function formatErroneousChoice(int $vehiclesCount): string
    {
        return PHP_EOL . sprintf(
            "Invalid choice. Please enter a number between 1 and %d%s",
            $vehiclesCount,
            PHP_EOL
        );
    }

    private function formatRaceTimesTitle(): string
    {
        return "** Race times: **" . PHP_EOL;
    }

    private function formatRaceTime(
        string     $name,
        string|float|int $time
    ): string
    {
        return sprintf(
                "%s: Finished after %s",
                $name,
                $time
            ) . PHP_EOL;
    }

    private function choiceIsValid(
        string $choice,
        int    $vehiclesCount
    ): bool
    {
        return (is_numeric($choice)) &&
            ($choice > 0) &&
            ($choice <= $vehiclesCount);
    }
}