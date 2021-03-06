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
 * Class NullWrapper
 *
 * @author  Dan McAdams
 * @package RoadBunch\Wrapper
 */
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
