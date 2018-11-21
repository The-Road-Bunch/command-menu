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

/**
 * Class Option
 *
 * @package RoadBunch\CommandMenu
 */
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
