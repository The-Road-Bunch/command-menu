<?php declare(strict_types=1);


namespace RoadBunch\CommandMenu;


class Option
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $label
     */
    public $label;

    /**
     * Option constructor.
     *
     * @param string $name
     * @param string $label
     */
    public function __construct(string $name, string $label)
    {
        $this->name  = $name;
        $this->label = $label;
    }
}
