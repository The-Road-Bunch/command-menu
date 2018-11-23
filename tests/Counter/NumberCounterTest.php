<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/command-menu package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\Counter;


use PHPUnit\Framework\TestCase;
use RoadBunch\Counter\NumberCounter;

/**
 * Class NumberCounterTest
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\Counter
 */
class NumberCounterTest extends TestCase
{
    public function testDefaultStartAtOne()
    {
        $counter = new TestNumberCounter();
        $this->assertEquals(1, $counter->getStartNumber());
    }

    public function testFirstNextCallGetsStartNumber()
    {
        $startNumber = rand(0, 50);
        $counter     = new NumberCounter($startNumber);

        $this->assertEquals($startNumber, $counter->next());
    }

    public function testNextReturnsConsecutiveNumbers()
    {
        $counter = new NumberCounter();
        for ($i = 1; $i < 10; $i++) {
            $this->assertEquals($i, $counter->next());
        }
    }

    public function testReset()
    {
        $startNumber = rand(0, 50);
        $counter     = new NumberCounter($startNumber);

        $counter->next();
        $counter->next();
        $counter->reset();

        $this->assertEquals($startNumber, $counter->next());
    }
}

class TestNumberCounter extends NumberCounter
{
    public function getStartNumber()
    {
        return $this->startNumber;
    }
}
