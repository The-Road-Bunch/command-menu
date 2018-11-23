<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/command-menu package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\CommandMenu;


use RoadBunch\CommandMenu\Option;

/**
 * Class OptionBuilder
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\CommandMenu
 */
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
