<?php

/**
 * This file is part of the theroadbunch/command-menu package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wrapper;


use PHPUnit\Framework\TestCase;
use RoadBunch\Wrapper\NullWrapper;

/**
 * Class NullWrapperTest
 *
 * @author  Dan McAdams
 * @package Wrapper
 */
class NullWrapperTest extends TestCase
{
    public function testReturnsOriginalString()
    {
        $wrapper = new NullWrapper();
        $str     = 'cricket';

        $this->assertEquals($str, $wrapper->wrap($str));
    }
}
