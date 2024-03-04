<?php

namespace App;

use App\Data\DTOs\PlayerDTO;

/**
 * This class represents a single race instance and handles its logic.
 */
class Race
{
    const SIXTY_MINS = 60;
    private int $distance = 100; // Default distance
    private array $players = []; // PlayerDTO[]
    private string $winner;
    private array $raceTimes = [];
    private array $formattedRaceTimes = [];
    private bool $isTie = false;

    public function __construct(array $players)
    {
        $this->players = $players;
    }

    /**
     * Simulates the race by calculating the time for each player.
     */
    public function run(): void
    {
        /**
         * @var PlayerDTO $player
         */
        foreach ($this->players as &$player) {
            $time = $this->calculateTime(
                $player->getMaxSpeed()
            );
            $this->raceTimes[$player->getName()] = $time;

            $player->setTime($time);
        }

        $this->determineWinner();

        if ($this->isItATie()) {
            $this->isTie = true;
        }
    }

    /**
     * Determines the winner of the race based on shortest time.
     */
    private function determineWinner(): void
    {
        /**
         * @var PlayerDTO $player
         */
        foreach ($this->players as $player) {
            if ($player->getTimeToFinish() === $this->getWinningTime()) {
                $this->winner = $player->getName();
                break;
            }
        }
    }

    private function calculateTime(
        int|float $maxSpeed
    ): float|int
    {
        return ($this->distance / $maxSpeed);
    }

    private function isItATie(): bool
    {
        return ($this->getWinningTime() == $this->getLosingTime());
    }

    private function getWinningTime(): int|float
    {
        return min(array_values($this->raceTimes));
    }

    private function getLosingTime(): int|float
    {
        return max(array_values($this->raceTimes));
    }

    /**
     * @return string|null The name of the winning vehicle, or null if there's no clear winner.
     */
    public function getWinner(): ?string
    {
        return $this->isTie
            ? $this->formatItsATie()
            : $this->winner;
    }

    /**
     * @return array An associative array where keys are vehicle names and values are race completion times.
     */
    public function getFormattedRaceTimes(): array
    {
        foreach ($this->raceTimes as $name => $time) {
            $this->formattedRaceTimes[$name] = $this->formatTime($time);
        }

        return $this->formattedRaceTimes;
    }

    /**
     * Format float time to human-readable (hour:minutes (HH:mm))
     *
     * @param float|int $floatTime
     * @return string
     */
    public function formatTime(
        float|int $floatTime
    ): string
    {
        $totalMinutes = ($floatTime * self::SIXTY_MINS);

        // Extract hour
        $hours = floor(
            $totalMinutes / self::SIXTY_MINS
        );

        $minutes = floor($totalMinutes) % self::SIXTY_MINS;

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    public function formatItsATie(): string
    {
        return 'Its a tie';
    }
}
