<?php

/**
 * This file is part of the theroadbunch/command-menu package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\CommandMenu;

use RoadBunch\CommandMenu\Exception\EmptySelectorException;
use RoadBunch\CommandMenu\Option;
use PHPUnit\Framework\TestCase;

/**
 * Class OptionTest
 *
 * @package RoadBunch\Tests\CommandMenu
 */
class OptionTest extends TestCase
{
    public function testCreateOption()
    {
        $name     = 'name';
        $label    = 'label';
        $selector = 'selector';

        $option = new Option($name, $label, $selector);
        $this->assertEquals($name, $option->name);
        $this->assertEquals($label, $option->label);
        $this->assertEquals($selector, $option->selector);
    }

    public function testCreateOptionNoSelector()
    {
        $option = new Option('name', 'label');
        $this->assertInstanceOf(Option::class, $option);
        $this->assertEquals('', $option->selector);
    }

    public function testCreateWithEmptyNameThrowsInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Option('', 'label', 'selector');
    }

    public function testCreateWithEmptyLabelThrowsInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Option('name', '', 'selector');
    }
}
