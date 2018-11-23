<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 11/23/18
 * Time: 4:41 PM
 */

namespace RoadBunch\Wrapper;

/**
 * Class ParenthesisWrapper
 *
 * @author  Dan McAdams
 * @package RoadBunch\Wrapper
 */
class ParenthesisWrapper implements WrapperInterface
{
    /**
     * Wrap a string
     *
     * @param string $string
     * @return string
     */
    public function wrap(string $string): string
    {
        return sprintf('(%s)', $string);
    }
}
