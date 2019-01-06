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
use RoadBunch\CommandMenu\Exception\DuplicateSelectorException;
use RoadBunch\Counter\NumberCounter;
use RoadBunch\Wrapper\NullWrapper;
use RoadBunch\Wrapper\WrapperInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class Menu
 *
 * @author  Dan McAdams
 * @package RoadBunch\CommandMenu
 */
class Menu implements MenuInterface
{
    /** @var Option[] $optionMap */
    protected $optionMap = [];

    /** @var SymfonyStyle $io */
    protected $io;

    /** @var NumberCounter $counter */
    protected $counter;

    /** @var WrapperInterface $wrapper */
    protected $wrapper;

    /** @var string $title */
    protected $title;

    /**
     * Menu constructor.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->io      = new SymfonyStyle($input, $output);
        $this->counter = new NumberCounter();
        $this->wrapper = new NullWrapper();
    }

    /**
     * Wrap menu selectors, eg. (q) or [q]
     *
     * @example
     *  Using new Wrapper('', ')');
     *
     * // output
     *
     * 1) Option
     * 2) Option
     * 3) Option
     *
     * @param WrapperInterface $wrapper
     */
    public function setSelectorWrapper(WrapperInterface $wrapper)
    {
        $this->wrapper = $wrapper;
    }

    /**
     * Add an option to the menu
     * If a selector is not provided, an incrementing integer will be assigned to the menu option
     *
     * @param string $name
     * @param string $label
     * @param string $selector
     */
    public function addOption(string $name, string $label, string $selector = ''): void
    {
        $this->appendOption(new Option($name, $label, $selector));
    }

    /**
     * Set the menu options
     * This will override any options previously set or added
     *
     * @param Option[]|iterable $options
     */
    public function setOptions(iterable $options): void
    {
        $this->reset();

        foreach ($options as $option) {
            if (!$option instanceof Option) {
                throw new \InvalidArgumentException('Items in array must be an instance of Object');
            }
            $this->appendOption($option);
        }
    }

    /**
     * Adds a title to the menu.
     *
     * @param string $message
     */
    public function title(string $message): void
    {
        $this->title = $message;
    }

    /**
     * Render the menu to output
     */
    public function render(): void
    {
        $this->renderTitle();
        foreach ($this->optionMap as $option) {
            $selector = array_search($option, $this->optionMap);
            $this->io->writeln(sprintf('%s %s', $this->wrapper->wrap($selector), $option->label));
        }
    }

    public function renderWithPrompt(): ?string
    {
        $this->render();
        $this->io->writeln('');
        return $this->promptForSelection();
    }

    /**
     * Check the user input against the menu options
     *
     * @param $selection
     *
     * @return string   the name of the matching option if a selection was made
     * @return null     if no option matches the selection
     */
    public function select($selection): ?string
    {
        // to make the menu selections case insensitive we'll convert all of 
        // the selector keys and the user's input to lower case then compare them
        $loweredKeyMap = array_change_key_case($this->optionMap, CASE_LOWER);
        $selection     = strtolower($selection);

        if (!empty($loweredKeyMap[$selection])) {
            return $loweredKeyMap[$selection]->name;
        }
        return null;
    }

    /**
     * Sets expectation of input from the user
     * returns the name of the selected menu option
     *
     * @param string $prompt
     *
     * @return string   the name of the matching option if a selection was made
     * @return null     if no option matches the selection
     */
    public function promptForSelection(string $prompt = 'Please make a selection'): ?string
    {
        $response = $this->io->ask($prompt);
        return $this->select($response);
    }

    private function appendOption(Option $option): void
    {
        $this->checkForDuplicates($option);
        $this->addToSelectorMap($option);
    }

    private function checkForDuplicates(Option $newOption): void
    {
        if (!empty($this->optionMap[$newOption->selector])) {
            throw new DuplicateSelectorException('An option has been already been provided with selector: '.$newOption->selector);
        }
        foreach ($this->optionMap as $option) {
            if ($option->name == $newOption->name || $option->label == $newOption->label) {
                throw new DuplicateOptionException();
            }
        }
    }

    private function renderTitle(): void
    {
        if (!empty($this->title)) {
            $this->io->section($this->title);
        }
    }

    private function addToSelectorMap(Option $option)
    {
        $selector                   = empty($option->selector) ? $this->counter->next() : $option->selector;
        $this->optionMap[$selector] = $option;
    }

    /**
     * Resets counters and options map to 0,
     * Like you just created a new menu, but with the same input, output, and title if any
     */
    private function reset(): void
    {
        $this->counter->reset();
        $this->optionMap = [];
    }
}
