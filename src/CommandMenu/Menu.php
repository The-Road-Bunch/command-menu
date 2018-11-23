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
    /** @var Option[] $options */
    protected $options = [];
    /** @var Option[] $optionSelectorMap */
    protected $optionSelectorMap = [];

    /** @var OutputInterface $output */
    protected $output;

    /** @var NumberCounter $counter */
    protected $counter;

    public function __construct(OutputInterface $output)
    {
        $this->output  = $output;
        $this->counter = new NumberCounter();
    }

    public function addOption(Option $option): void
    {
        $this->checkForDuplicates($option);
        $this->options[] = $option;
    }

    public function render(): void
    {
        $this->counter->reset();
        foreach ($this->options as $option) {
            $count = $this->counter->next();
            $this->output->writeln(sprintf('%s %s', $count, $option->label));
            $this->optionSelectorMap[$count] = $option;
        }
    }

    public function makeSelection($selection): ?Option
    {
        if (!empty($this->optionSelectorMap[$selection])) {
            return $this->optionSelectorMap[$selection];
        }
        return null;
    }

    private function checkForDuplicates(Option $newOption): void
    {
        foreach ($this->options as $option) {
            if ($option->name == $newOption->name || $option->label == $newOption->label) {
                throw new DuplicateOptionException();
            }
        }
    }
}
