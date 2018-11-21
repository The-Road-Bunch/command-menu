<?php declare(strict_types=1);


namespace RoadBunch\Tests\CommandMenu;


use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestOutput implements OutputInterface
{
    // we'll spy on the lines being provided here
    public $output = '';

    public function clear()
    {
        $this->output = '';
    }

    public function write($messages, $newline = false, $options = 0)
    {
    }

    public function writeln($messages, $options = 0)
    {
        foreach ((array) $messages as $message) {
            $this->output .= $message . PHP_EOL;
        }
    }

    public function setVerbosity($level) {}

    public function getVerbosity() {}

    public function isQuiet() {}

    public function isVerbose() {}

    public function isVeryVerbose() {}

    public function isDebug() {}

    public function setDecorated($decorated) {}

    public function isDecorated() {}

    public function setFormatter(OutputFormatterInterface $formatter) {}

    public function getFormatter() {}
}
