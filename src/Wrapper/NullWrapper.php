<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 11/23/18
 * Time: 5:14 PM
 */

namespace RoadBunch\Wrapper;


class NullWrapper implements WrapperInterface
{
    /**
     * Wrap a string
     *
     * @param string $string
     * @return string
     */
    public function wrap(string $string): string
    {
        return $string;
    }
}
