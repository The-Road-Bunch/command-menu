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

    public function addOption(string $name, string $label): void
    {
        $option = new Option($name, $label);

        $this->checkForDuplicates($option);
        $this->options[] = $option;
        $this->optionSelectorMap[$this->counter->next()] = $option;
    }

    public function render(): void
    {
        foreach ($this->options as $option) {
            $this->output->writeln(
                sprintf('%s %s', array_search($option->name, $this->optionSelectorMap), $option->label)
            );
        }
    }

    public function makeSelection($selection): ?string
    {
        if (!empty($this->optionSelectorMap[$selection])) {
            return $this->optionSelectorMap[$selection]->name;
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
