<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 11/23/18
 * Time: 4:38 PM
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
        $this->assertEquals('(Frank)', $wrapper->wrap('Frank'));
    }
}
