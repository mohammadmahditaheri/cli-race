<?php

namespace Tests\Utils;

use Exception;

class CLITest
{
    protected $process;
    protected array $pipes = [];
    protected string $output = '';
    protected array $inputs = [];

    /**
     * @throws Exception
     */
    public function __construct(
        string $command,
    )
    {
        // Open the process with proc_open
        $this->process = proc_open(
            $command,
            [
                0 => ['pipe', 'r'],  // stdin
                1 => ['pipe', 'w'],  // stdout
                2 => ['pipe', 'w'],  // stderr
            ],
            $this->pipes
        );

        // If the process is not valid, throw an exception
        if (!is_resource($this->process)) {
            throw new Exception('Could not create the process.');
        }
    }

    public function run(): string
    {
        // Write the input to the process
        $this->write(implode('', $this->inputs));

        // Get the output
        $this->output = $this->getOutput();

        // Close the process
        $this->close();

        return $this->read();
    }

    public function writeToTerminal(string $input): static
    {
        $this->inputs[] = $this->normalizeInput($input);

        return $this;
    }

    protected function normalizeInput(string $input): string
    {
        return rtrim(ltrim($input)) . "\n";
    }

    protected function write(string $input): void
    {
        fwrite($this->pipes[0], $input);
        fclose($this->pipes[0]); // Close the input pipe after writing
    }

    protected function getOutput(): string
    {
        $output = stream_get_contents($this->pipes[1]);
        fclose($this->pipes[1]);

        return $output;
    }

    protected function read(): string
    {
        return $this->output;
    }

    protected function close(): void
    {
        proc_close($this->process);
    }
}
