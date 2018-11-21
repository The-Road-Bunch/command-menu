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
use Symfony\Component\Console\Style\SymfonyStyle;

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
        $optOne = OptionBuilder::create()->withName("option_frank")->withLabel('Frank')->build();
        $optTwo = OptionBuilder::create()->withName("option_charlie")->withLabel('Charlie')->build();

        $this->menu->addOption($optOne);
        $this->menu->addOption($optTwo);

        $this->menu->render();

        $this->assertContains($optOne->label, $this->output->output);
        $this->assertContains($optTwo->label, $this->output->output);
    }

    public function testMakeSelection()
    {
        $optOne = OptionBuilder::create()->withName('option_waitress')->withLabel('The Waitress')->build();
        $optTwo = OptionBuilder::create()->withName('option_cricket')->withLabel('Cricket')->build();

        $this->menu->addOption($optOne);
        $this->menu->addOption($optTwo);
        $this->menu->render();

        $this->assertEquals($optTwo, $this->menu->makeSelection(2));
        $this->assertEquals($optOne, $this->menu->makeSelection(1));
        $this->assertNull($this->menu->makeSelection('fake selection'));
    }
}
