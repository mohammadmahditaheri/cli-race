<?php

require __DIR__ . '/vendor/autoload.php';

use App\Game;
use App\CommandLine;

$game = new Game(new CommandLine());
$game->run();


