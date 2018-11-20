<?php declare(strict_types=1);


namespace RoadBunch\CommandMenu\Tests;


use RoadBunch\CommandMenu\Option;

class OptionBuilder
{
    protected $name = 'Option One';
    protected $slug = 'option-one';

    public static function create()
    {
        return new self;
    }

    public function withName(string $name): OptionBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function withSlug(string $slug): OptionBuilder
    {
        $this->slug = $slug;
        return $this;
    }

    public function build()
    {
        return new Option($this->name, $this->slug);
    }
}
