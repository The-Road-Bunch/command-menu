<?php

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
use RoadBunch\Wrapper\NullWrapper;
use RoadBunch\Wrapper\WrapperInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Menu
 *
 * @author  Dan McAdams
 * @package RoadBunch\CommandMenu
 */
class Menu
{
    /** @var Option[] $optionMap */
    protected $optionMap = [];

    /** @var OutputInterface $output */
    protected $output;

    /** @var NumberCounter $counter */
    protected $counter;

    /** @var string $delimiter */
    protected $delimiter;

    /** @var WrapperInterface $wrapper */
    protected $wrapper;

    /**
     * Menu constructor.
     *
     * @param OutputInterface       $output
     * @param WrapperInterface|null $selectionWrapper wrap menu selectors, eg. (q) or [q]
     */
    public function __construct(OutputInterface $output, WrapperInterface $selectionWrapper = null)
    {
        $this->output    = $output;
        $this->counter   = new NumberCounter();
        $this->wrapper   = $selectionWrapper ?? new NullWrapper();
    }

    public function addOption(string $name, string $label, string $selector = null): void
    {
        $this->appendOption(new Option($name, $label), $selector);
    }

    /**
     * @param Option[] $options
     */
    public function setOptions(array $options): void
    {
        $this->counter->reset();
        $this->optionMap = [];

        foreach ($options as $option) {
            $this->appendOption($option);
        }
    }

    public function render(): void
    {
        foreach ($this->optionMap as $option) {
            $selector = array_search($option, $this->optionMap);
            $this->output->writeln(sprintf('%s %s', $this->wrapper->wrap($selector), $option->label));
        }
    }

    public function makeSelection($selection): ?string
    {
        if (!empty($this->optionMap[$selection])) {
            return $this->optionMap[$selection]->name;
        }
        return null;
    }

    private function appendOption(Option $option, string $selector = null)
    {
        $this->validateOption($option);
        $this->optionMap[$selector ?? $this->counter->next()] = $option;
    }

    private function validateOption(Option $newOption): void
    {
        foreach ($this->optionMap as $option) {
            if ($option->name == $newOption->name || $option->label == $newOption->label) {
                throw new DuplicateOptionException();
            }
        }
    }
}
