<?php

/**
 * This file is part of the theroadbunch/command-menu package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Wrapper;

/**
 * Class CustomWrapper
 *
 * @author  Dan McAdams
 * @package RoadBunch\Wrapper
 */
class Wrapper implements WrapperInterface
{
    protected $format;

    /**
     * Wrapper constructor.
     *
     * @param string $left
     * @param string $right
     */
    public function __construct(string $left, string $right)
    {
        $this->format = sprintf('%s%s%s', $left, '%s', $right);
    }

    /**
     * Wrap a string
     *
     * @param string $string
     * @return string
     */
    public function wrap(string $string): string
    {
        return sprintf($this->format, $string);
    }
}
