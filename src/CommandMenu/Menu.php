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
    protected $options = [];
    protected $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function addOption(Option $option): void
    {
        $this->checkForDuplicates($option);
        $this->options[$option->label] = $option->name;
    }

    public function render(): void
    {
        foreach ($this->options as $option) {
            $this->output->writeln($option);
        }
    }

    private function checkForDuplicates(Option $option)
    {
        if (isset($this->options[$option->label]) || in_array($option->name, $this->options)) {
            throw new DuplicateOptionException();
        }
    }
}
