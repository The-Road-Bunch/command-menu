<?php declare(strict_types=1);


namespace RoadBunch\CommandMenu;


use RoadBunch\CommandMenu\Exception\DuplicateOptionException;

class Menu
{
    protected $options = [];

    public function addOption(Option $option)
    {
        $this->checkForDuplicates($option);
        $this->options[$option->slug] = $option->name;
    }

    /**
     * @param Option $option
     *
     * @throws DuplicateOptionException
     */
    private function checkForDuplicates(Option $option)
    {
        if (isset($this->options[$option->slug]) || in_array($option->name, $this->options)) {
            throw new DuplicateOptionException();
        }
    }
}
