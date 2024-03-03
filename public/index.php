<?php
error_reporting(E_ALL);

use App\Data\Repositories\VehicleRepository as Repo;
use App\Game;
use App\Presentation\UI;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';


$game = new Game(
    new Repo(),
    new UI()
);
$game->run();


