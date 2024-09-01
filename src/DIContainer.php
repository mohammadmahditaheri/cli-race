<?php

namespace App;

use Pimple\Container;
use App\Presentation\UI;
use App\Utilities\JsonHandler;
use App\Utilities\SpeedUnitConverter;
use App\Contracts\Presentation\UIInterface;
use App\Data\Repositories\VehicleRepository;
use App\Contracts\Utilities\JsonHandlerInterface;
use App\Contracts\Utilities\SpeedUnitConverterInterface;
use App\Contracts\Repositories\VehicleRepositoryInterface;
use App\Contracts\Utilities\CommandLineInterface;
use App\Utilities\CommandLine;
use Termwind\Components\Dd;

class DIContainer
{
    private Container $container;
    private static ?DIContainer $instance = null;

    private function __construct()
    {
        $this->container = new Container();

        // Register services
        $this->registerServices();
    }

    public static function make(): DIContainer
    {
        if (!self::$instance) {
            self::$instance = new DIContainer();
        }


        return self::$instance;
    }

    public function get(string $service)
    {
        return $this->container[$service];
    }

    /**
     * ---------------------------------------------------
     * ----------------- Private Methods -----------------
     * ---------------------------------------------------
     */

    private function registerServices(): void
    {
        $this->bindInterface(
            JsonHandlerInterface::class,
            JsonHandler::class
        );
        $this->bindInterface(
            SpeedUnitConverterInterface::class,
            SpeedUnitConverter::class
        );
        $this->bindInterface(
            CommandLineInterface::class,
            CommandLine::class,
        );
        $this->bindInterface(
            VehicleRepositoryInterface::class,
            VehicleRepository::class,
            [
                JsonHandlerInterface::class,
                SpeedUnitConverterInterface::class
            ]
        );
        $this->bindInterface(
            CommandLineInterface::class,
            CommandLine::class,
        );
        $this->bindInterface(
            UIInterface::class,
            UI::class,
            [
                'cli' => CommandLineInterface::class,
            ]
        );
        $this->bindInterface(
            Game::class,
            Game::class,
            [
                VehicleRepositoryInterface::class,
                UIInterface::class
            ]
        );
    }

     /**
      * Binds an interface to a concrete implementation.
      *
      * @param string $interface The interface to bind.
      * @param string $concrete The concrete implementation.
      * @param array<string> $dependencies The dependencies to pass to the concrete implementation.
      */
    private function bindInterface(
        string $interface,
        string $concrete,
        array $dependencies = []
    ): void
    {
        $this->container[$interface] = function ($c) use ($concrete, $dependencies) {
            $args = [];
            foreach ($dependencies as $arg => $dependency) {
                $args[$arg] = $c[$dependency];
            }

            return new $concrete(...$args);
        };
    }
}
