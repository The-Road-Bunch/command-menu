<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 11/23/18
 * Time: 4:16 PM
 */

namespace RoadBunch\Wrapper;

/**
 * Interface WrapperInterface
 *
 * @author  Dan McAdams
 * @package RoadBunch\Wrapper
 */
interface WrapperInterface
{
    /**
     * Wrap a string
     *
     * @param string $string
     * @return string
     */
    public function wrap(string $string): string;
}
