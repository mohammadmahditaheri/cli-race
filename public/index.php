<?php
error_reporting(E_ALL);

use App\Game;
use App\DIContainer;


define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

DIContainer::make()->get(Game::class)->run();


