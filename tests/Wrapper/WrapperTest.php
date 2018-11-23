<?php

/**
 * This file is part of the theroadbunch/command-menu package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\Wrapper;


use PHPUnit\Framework\TestCase;
use RoadBunch\Wrapper\Wrapper;

/**
 * Class WrapperTest
 *
 * @author  Dan McAdams
 * @package StringWrapper
 */
class WrapperTest extends TestCase
{
    public function testCreatCustomWrapper()
    {
        $wrapper = new Wrapper('<', '>');
        $str  = 'charlie';
        $this->assertEquals('<'.$str.'>', $wrapper->wrap($str));
    }
}
