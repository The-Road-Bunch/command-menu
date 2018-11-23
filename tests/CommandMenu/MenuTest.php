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
use RoadBunch\Counter\NumberCounter;
use RoadBunch\Wrapper\ParenthesisWrapper;
use RoadBunch\Wrapper\Wrapper;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MenuTest
 *
 * @author  Dan McAdams
 * @package RoadBunch\Tests\CommandMenu
 */
class MenuTest extends TestCase
{
    const DEFAULT_DELIMITER = ') ';

    /** @var TestOutput|OutputInterface */
    protected $output;
    /** @var Menu|TestMenu $menu */
    protected $menu;
    /** @var Option[] */
    protected $options;
    /** @var ParenthesisWrapper $defaultWrapper */
    protected $defaultWrapper;

    protected function setUp()
    {
        $this->output         = new TestOutput();
        $this->menu           = new TestMenu($this->output);
        $this->defaultWrapper = new ParenthesisWrapper();

        // create some options for our menu
        $this->options = $this->createRandomOptions(5);
        // add them to the menu
        $this->setMenuOptions($this->options);
    }

    /**
     * @dataProvider duplicateOptionProvider
     */
    public function testAddDuplicateOptionThrowsException(Option $optionOne, Option $optionTwo)
    {
        $this->expectException(DuplicateOptionException::class);

        $this->menu->addOption($optionOne->name, $optionOne->label);
        $this->menu->addOption($optionTwo->name, $optionTwo->label);
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

    public function testDefaultSelectorWrapperIsParenthesis()
    {
        $this->assertInstanceOf(get_class($this->defaultWrapper), $this->menu->getWrapper());
    }

    public function testRenderDefaultMenu()
    {
        $this->assertRendersMenuWithOptions($this->options);
    }

    public function testSetCustomWrapper()
    {
        $wrapper  = new Wrapper('<', '>');
        $menu     = new Menu($this->output, $wrapper);
        $selector = 'd';

        $menu->addOption('dee', 'Bird', $selector);
        $menu->render();

        $this->assertContains(sprintf('%s', $wrapper->wrap($selector)), $this->output->output);
    }

    public function testSetOptions()
    {
        $oldOption  = OptionBuilder::create()->build();
        $newOptions = $this->createRandomOptions(3);

        $this->menu->addOption($oldOption->name, $oldOption->label);
        $this->menu->setOptions($newOptions);

        $this->render();

        $this->assertNotContains($oldOption->label, $this->output->output);
    }

    public function testRenderMultipleTimesCreatesSameMenu()
    {
        $this->render();
        $output = $this->output->output;
        $this->render();
        $this->assertEquals($output, $this->output->output);
    }

    public function testMakeSelection()
    {
        $this->render();

        $count = 1;
        foreach ($this->options as $option) {
            $this->assertEquals($option->name, $this->menu->makeSelection($count));
            $count++;
        }
        $this->assertNull($this->menu->makeSelection('fake selection'));
    }

    public function testCustomOptionSelector()
    {
        $selector = 'mantis';
        $option   = OptionBuilder::create()
                                 ->withName("doc_mantis")
                                 ->withLabel('Dr. Mantis Toboggan, MD')
                                 ->build();

        $this->menu->addOption($option->name, $option->label, $selector);
        $this->render();

        $this->assertEquals($option->name, $this->menu->makeSelection($selector));
    }

    private function createRandomOptions(int $numOptions)
    {
        $options = [];
        for ($i = 0; $i < $numOptions; $i++) {
            $options[] = OptionBuilder::create()->withName(uniqid())->withLabel(uniqid())->build();
        }
        return $options;
    }

    private function setMenuOptions($options)
    {
        foreach ($options as $option) {
            $this->menu->addOption($option->name, $option->label);
        }
    }

    private function render(): void
    {
        $this->output->clear();
        $this->menu->render();
    }

    /**
     * @param Option[] $options
     */
    private function assertRendersMenuWithOptions($options): void
    {
        $this->render();

        $count = 1;
        foreach ($options as $option) {
            $expected = sprintf('%s %s', $this->defaultWrapper->wrap((string)$count), $option->label);
            $this->assertContains($expected, $this->output->output);
            $count++;
        }
    }
}

class TestMenu extends Menu
{
    public function getWrapper()
    {
        return $this->wrapper;
    }
}
