<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 11/23/18
 * Time: 5:25 PM
 */

namespace Wrapper;


use PHPUnit\Framework\TestCase;
use RoadBunch\Wrapper\NullWrapper;

class NullWrapperTest extends TestCase
{
    public function testReturnsOriginalString()
    {
        $wrapper = new NullWrapper();
        $str     = 'cricket';

        $this->assertEquals($str, $wrapper->wrap($str));
    }
}
