<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 11/23/18
 * Time: 4:10 PM
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
