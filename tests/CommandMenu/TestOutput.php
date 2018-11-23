<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/command-menu package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\CommandMenu;


use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TestOutput
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\CommandMenu
 */
class TestOutput implements OutputInterface
{
    // we'll spy on the lines being provided here
    public $output = '';

    /**
     * clear the output here because it's just a string we're storing in memory
     * for the test. Actual output doesn't get buffered like this, so we're really
     * testing that the menu produces the same result every time we render it.
     */
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
