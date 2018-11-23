<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/command-menu package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Tests\CommandMenu;


use RoadBunch\CommandMenu\Exception\DuplicateOptionException;
use RoadBunch\CommandMenu\Menu;
use RoadBunch\CommandMenu\Option;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MenuTest
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\CommandMenu
 */
class MenuTest extends TestCase
{
    /** @var TestOutput|OutputInterface */
    protected $output;
    /** @var Menu $menu */
    protected $menu;

    protected function setUp()
    {
        $this->output = new TestOutput();
        $this->menu   = new Menu($this->output);
    }

    /**
     * @dataProvider duplicateOptionProvider
     */
    public function testAddDuplicateOptionThrowsException(Option $optionOne, Option $optionTwo)
    {
        $this->expectException(DuplicateOptionException::class);

        $this->menu->addOption($optionOne);
        $this->menu->addOption($optionTwo);
    }

    public function duplicateOptionProvider(): \Generator
    {
        // duplicate options
        yield [OptionBuilder::create()->build(), OptionBuilder::create()->build()];
        // same label, different name
        yield [OptionBuilder::create()->withName(uniqid())->build(), OptionBuilder::create()->build()];
        // different label, same name
        yield [OptionBuilder::create()->withLabel(uniqid())->build(), OptionBuilder::create()->build()];
    }

    public function testRenderDefaultMenu()
    {
        $options = $this->createRandomOptions(2);
        $this->addMenuOptions($options);

        $this->menu->render();

        foreach ($options as $option) {
            $this->assertContains($option->label, $this->output->output);
        }
    }

    public function testMakeSelection()
    {
        $this->addMenuOptions($options = $this->createRandomOptions(2));
        $this->menu->render();

        $count = 1;
        foreach ($options as $option) {
            $this->assertEquals($option, $this->menu->makeSelection($count));
            $count++;
        }
        $this->assertNull($this->menu->makeSelection('fake selection'));
    }

    private function createRandomOptions(int $numOptions)
    {
        $options = [];
        for ($i = 0; $i < $numOptions; $i++) {
            $options[] = OptionBuilder::create()->withName(uniqid())->withLabel(uniqid())->build();
        }
        return $options;
    }

    private function addMenuOptions($options)
    {
        foreach ($options as $option) {
            $this->menu->addOption($option);
        }
    }
}
