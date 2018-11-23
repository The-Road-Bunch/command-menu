<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/command-menu package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\CommandMenu;


use RoadBunch\CommandMenu\Exception\DuplicateOptionException;
use RoadBunch\Counter\NumberCounter;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Menu
 *
 * @author  Dan McAdams
 * @package RoadBunch\CommandMenu
 */
class Menu
{
    /** @var string self::DEFAULT_DELIMITER */
    const DEFAULT_DELIMITER = ') ';

    /** @var Option[] $optionMap */
    protected $optionMap = [];

    /** @var OutputInterface $output */
    protected $output;

    /** @var NumberCounter $counter */
    protected $counter;

    /** @var string $delimiter */
    protected $delimiter = self::DEFAULT_DELIMITER;

    public function __construct(OutputInterface $output)
    {
        $this->output  = $output;
        $this->counter = new NumberCounter();
    }

    public function setOptionDelimiter(string $delimiter)
    {
        $this->delimiter = $delimiter;
    }

    public function addOption(string $name, string $label, string $selector = null): void
    {
        $selector = $selector ?? $this->counter->next();
        $option   = new Option($name, $label);

        $this->checkForDuplicates($option);
        $this->optionMap[$selector] = $option;
    }

    public function render(): void
    {
        foreach ($this->optionMap as $option) {
            $selector = array_search($option, $this->optionMap);
            $this->output->writeln(sprintf('%s%s%s', $selector, $this->delimiter, $option->label));
        }
    }

    public function makeSelection($selection): ?string
    {
        if (!empty($this->optionMap[$selection])) {
            return $this->optionMap[$selection]->name;
        }
        return null;
    }

    private function checkForDuplicates(Option $newOption): void
    {
        foreach ($this->optionMap as $option) {
            if ($option->name == $newOption->name || $option->label == $newOption->label) {
                throw new DuplicateOptionException();
            }
        }
    }
}
