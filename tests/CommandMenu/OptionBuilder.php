<?php declare(strict_types=1);


namespace RoadBunch\Tests\CommandMenu;


use RoadBunch\CommandMenu\Option;

class OptionBuilder
{
    protected $name  = 'option_one';
    protected $label = 'Option One';

    public static function create()
    {
        return new self;
    }

    public function withName(string $name): OptionBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function withLabel(string $label): OptionBuilder
    {
        $this->label = $label;
        return $this;
    }

    public function build()
    {
        return new Option($this->name, $this->label);
    }
}
