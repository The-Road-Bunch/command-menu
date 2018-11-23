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
use RoadBunch\Wrapper\ParenthesisWrapper;

/**
 * Class ParenthesisWrapper
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\Wrapper
 */
class ParenthesisWrapperTest extends TestCase
{
    public function testWrapsStringInParenthesis()
    {
        $wrapper = new ParenthesisWrapper();
        $str  = 'Frank';
        $this->assertEquals('('.$str.')', $wrapper->wrap($str));
    }
}
