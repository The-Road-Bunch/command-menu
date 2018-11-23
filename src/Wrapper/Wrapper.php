<?php

/**
 * Created by PhpStorm.
 * User: dan
 * Date: 11/23/18
 * Time: 4:26 PM
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
