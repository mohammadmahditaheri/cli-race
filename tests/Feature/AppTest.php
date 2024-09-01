<?php

$indexFile = dirname(__DIR__, 2)
    . DIRECTORY_SEPARATOR
    . 'public'
    . DIRECTORY_SEPARATOR
    . 'index.php';

it('it runs and declares winners successfully', function () use ($indexFile) {
    $cli = new \Tests\Utils\CLITest(command: "php $indexFile");
    $output = $cli->writeToTerminal('1')
        // Player 1 chooses Car, Player 2 chooses Motorcycle
        ->writeToTerminal('2')
        ->run();

    // Assertions on the output
    expect($output)->toContain(
        "Welcome to the CLI Racing Game!",
        "Race is started! >>>",
        "Race is running! >>>",
        "Race is finished!",
        "And the winner is: Player No. 2!" // Assuming motorcycle is faster
    );
});
