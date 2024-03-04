<?php

namespace App;

use App\Contracts\Presentation\UIInterface;
use App\Contracts\Repositories\VehicleRepositoryInterface;
use App\Data\DTOs\PlayerDTO;
use App\Data\DTOs\VehicleDTO;
use App\Utilities\CommandLine;

/**
 * This class represents the game and handles
 * its overall flow.
 */
class Game
{
    private VehicleRepositoryInterface $vehicleRepository;
    private UIInterface $ui;
    private array $vehicles;

    private const ONE = 1;
    private const TWO = 2;

    public function __construct(
        VehicleRepositoryInterface $vehicleRepository,
        UIInterface                $ui
    )
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->ui = $ui;

        // load vehicles
        $this->vehicles = $this->loadVehicles();
    }

    /**
     * Runs the game by executing its different stages.
     */
    public function run(): void
    {
        // welcome
        $this->welcome();

        // load players with choosing their vehicles
        $players = [
            $this->getPlayerOne(),
            $this->getPlayerTwo()
        ];

        // race
        $race = new Race($players);
        $race->run();

        $this->displayRace();

        // results
        $this->displayResults($race);
    }

    private function welcome(): void
    {
        $this->ui->displayWelcome();
    }

    /**
     * Loads the list of available vehicles from the JSON file.
     *
     * @return VehicleDTO[] Array of VehicleDTO objects.
     */
    private function loadVehicles(): array
    {
        return $this->vehicleRepository->getVehicles();
    }

    private function getPlayerOne(): PlayerDTO
    {
        return $this->instantiatePlayer(self::ONE);
    }

    private function getPlayerTwo(): PlayerDTO
    {
        return $this->instantiatePlayer(self::TWO);
    }

    private function instantiatePlayer(
        int $playerNumber
    ): PlayerDTO
    {
        $chosenVehicle = $this->ui->getPlayerVehicleChoice(
            $playerNumber,
            $this->vehicles
        );

        return new PlayerDTO(
            playerNo: $playerNumber,
            vehicle: $chosenVehicle
        );
    }

    /**
     * Displays the results of the race, including the winner and times.
     *
     * @param Race $race The completed race object.
     */
    private function displayResults(Race $race): void
    {
        $this->ui->displayWinner(
            $race->getWinner()
        );
        $this->ui->displayRaceTimes(
            $race->getFormattedRaceTimes()
        );
    }

    private function displayRace(): void
    {
        $this->ui->displayRaceIsRunning();
    }
}