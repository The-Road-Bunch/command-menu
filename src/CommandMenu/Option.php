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
 * @author  Dan McAdams
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
     * @var string|null
     */
    public $selector;

    /**
     * Option constructor.
     *
     * @param string      $name
     * @param string      $label
     * @param string|null $selector
     */
    public function __construct(string $name, string $label, string $selector = null)
    {
        if (empty($name) || empty($label)) {
            throw new \InvalidArgumentException();
        }
        $this->name     = $name;
        $this->label    = $label;
        $this->selector = $selector;
    }
}
