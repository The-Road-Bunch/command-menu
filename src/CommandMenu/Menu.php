<?php declare(strict_types=1);


namespace RoadBunch\CommandMenu;


use RoadBunch\CommandMenu\Exception\DuplicateOptionException;
use Symfony\Component\Console\Output\OutputInterface;

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

    /**
     * @param Option $option
     *
     * @throws DuplicateOptionException
     */
    private function checkForDuplicates(Option $option)
    {
        if (isset($this->options[$option->label]) || in_array($option->name, $this->options)) {
            throw new DuplicateOptionException();
        }
    }
}
