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
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Menu
 *
 * @author  Dan McAdams
 * @package RoadBunch\CommandMenu
 */
class Menu
{
    protected $options   = [];
    protected $optionMap = [];

    /** @var OutputInterface $output */
    protected $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function addOption(Option $option): void
    {
        $this->checkForDuplicates($option);
        $this->options[$option->name] = $option->label;
    }

    public function render(): void
    {
        $count = 1;
        foreach ($this->options as $name => $label) {
            $this->output->writeln(sprintf('%s %s', $count, $label));
            $this->optionMap[$count] = $name;
            $count++;
        }
    }

    public function makeSelection($selection): ?Option
    {
        if (!empty($this->optionMap[$selection])) {
            $name = $this->optionMap[$selection];
            return new Option($name, $this->options[$name]);
        }
        return null;
    }

    private function checkForDuplicates(Option $option): void
    {
        if (isset($this->options[$option->name]) || in_array($option->label, $this->options)) {
            throw new DuplicateOptionException();
        }
    }
}
