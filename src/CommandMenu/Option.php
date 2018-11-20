<?php declare(strict_types=1);


namespace RoadBunch\CommandMenu;


class Option
{
    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $slug
     */
    public $slug;

    /**
     * Option constructor.
     *
     * @param string $name
     * @param string $slug
     */
    public function __construct(string $name, string $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }
}
