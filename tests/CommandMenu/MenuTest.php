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

use InvalidArgumentException;
use RoadBunch\CommandMenu\Exception\DuplicateOptionException;
use RoadBunch\CommandMenu\Menu;
use RoadBunch\CommandMenu\Option;
use PHPUnit\Framework\TestCase;
use RoadBunch\Wrapper\Wrapper;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\Output;
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
    /** @var TestOutput|OutputInterface $output */
    protected $output;
    /** @var InputInterface $input */
    protected $input;
    /** @var Menu|TestMenu $menu */
    protected $menu;
    /** @var Option[] */
    protected $options;

    protected function setUp()
    {
        $this->input  = $this->createMock(Input::class);
        $this->output = new TestOutput();
        $this->menu   = new TestMenu($this->input, $this->output);

        // create some options for our menu
        $this->options = $this->createRandomOptions(5);
    }

    public function testAddOption()
    {
        $option = OptionBuilder::create()->build();
        $this->menu->addOption($option->name, $option->label);

        $this->assertTrue(in_array($option, $this->menu->getOptions()));
    }

    /**
     * @dataProvider duplicateOptionProvider
     */
    public function testAddDuplicateOptionThrowsDuplicateOptionException(Option $optionOne, Option $optionTwo)
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

    public function testSetOptions()
    {
        $oldOption  = OptionBuilder::create()->build();
        $newOptions = $this->createRandomOptions(3);

        $this->menu->addOption($oldOption->name, $oldOption->label);
        $this->menu->setOptions($newOptions);

        $this->render();
        $this->assertRendersMenuWithOptions($newOptions);
        $this->assertNotContains($oldOption->label, $this->output->output);
    }

    public function testSetNonArrayOfOptionsThrowsInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Items in array must be an instance of Object');

        $options = ['not', 'instances', 'of', 'Option'];
        $this->menu->setOptions($options);
    }

    public function testCustomOptionSelector()
    {
        $selector = 'mantis';
        $option   = OptionBuilder::create()
                                 ->withName("doc_mantis")
                                 ->withLabel('Dr. Mantis Toboggan, MD')
                                 ->withSelector($selector)
                                 ->build();

        $this->menu->addOption($option->name, $option->label, $option->selector);
        $this->render();

        $this->assertEquals($option->name, $this->menu->select($selector));
    }

    public function testSetSelectorWrapper()
    {
        $wrapper  = new Wrapper('<', '>');
        $selector = 'd';
        $option   = OptionBuilder::create()->withSelector($selector)->build();

        $this->menu->setSelectorWrapper($wrapper);
        $this->menu->addOption($option->name, $option->label, $option->selector);
        $this->render();

        $this->assertContains(sprintf('%s', $wrapper->wrap($selector)), $this->output->output);
    }

    /**
     * This test that the menu prints an integer selector and a label by default
     *
     * @example 1 Option
     * @example 2 A different Option
     *
     * @depends testSetOptions
     */
    public function testRenderMenu()
    {
        $this->menu->setOptions($this->options);
        $this->menu->render();

        // turn the output into an array we can loop through line by line
        $outputArray = explode(PHP_EOL, $this->output->output);
        // clear the last element, it's going to be a blank line in the test
        array_pop($outputArray);

        // the options and the menu lines should line up exactly
        $count         = 0;
        $currentOption = current($this->options);

        foreach ($outputArray as $line) {
            $this->assertContains($currentOption->label, $this->output->output);
            $this->assertContains((string) ++$count, $line);
            next($this->options);
        }
    }

    /**
     * @depends testSetOptions
     */
    public function testRenderMultipleTimesCreatesSameMenu()
    {
        $this->menu->setOptions($this->options);

        $this->render();
        $output = $this->output->output;
        $this->render();
        $this->assertEquals($output, $this->output->output);
    }

    public function testRenderTitle()
    {
        $title = 'Menu Title';
        $this->menu->title($title);
        $this->render();

        // Menu Title
        // ==========
        $output = $this->output->output;

        $this->assertContains($title, $output);
        $this->assertContains(PHP_EOL, $output);
        $this->assertContains(str_repeat('-', strlen($title)), $output);
    }

    public function testMakeSelection()
    {
        $this->menu->setOptions($this->options);
        $this->render();

        $count = 1;
        foreach ($this->options as $option) {
            $this->assertEquals($option->name, $this->menu->select($count));
            $count++;
        }
        $this->assertNull($this->menu->select('fake selection'));
    }

    public function testMakeSelectionIsCaseInsensitive()
    {
        $selector          = 'q';
        $upperCaseSelector = strtoupper($selector);
        $option            = OptionBuilder::create()->withSelector($selector)->build();

        $this->menu->addOption($option->name, $option->label, $option->selector);
        $this->assertEquals($option->name, $this->menu->select($selector));
        $this->assertEquals($option->name, $this->menu->select($upperCaseSelector));
    }

    public function testSelectFromUserInput()
    {
        $option   = OptionBuilder::create()->withSelector('selector')->build();
        $defaultPrompt    = 'Please make a selection';
        $customPrompt     = 'Yo, make a pick';

        // creating a spy styler, this is how we ask the user for input,
        // we want to fake that part of the process
        $style                   = new TestSymfonyStyle($this->input, $this->output);
        $style->expectedSelector = $option->selector;

        // replace the style created in the class so we can spy on it
        $this->menu->injectSymfonyStyle($style);
        $this->menu->setOptions($this->options);
        $this->menu->addOption($option->name, $option->label, $option->selector);

        $this->render();
        $result = $this->menu->promptForSelection();

        $this->assertEquals($defaultPrompt, $style->question);
        $this->assertEquals($result, $option->name);

        $result = $this->menu->promptForSelection($customPrompt);

        $this->assertEquals($customPrompt, $style->question);
        $this->assertEquals($result, $option->name);
    }

    /**
     * @param int $numOptions
     *
     * @return Option[]
     */
    private function createRandomOptions(int $numOptions)
    {
        $options = [];
        for ($i = 0; $i < $numOptions; $i++) {
            $options[] = OptionBuilder::create()->withName(uniqid())->withLabel(uniqid())->build();
        }
        return $options;
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
            $expected = sprintf('%s %s', (string) $count, $option->label);
            $this->assertContains($expected, $this->output->output);
            $count++;
        }
    }
}

class TestSymfonyStyle extends SymfonyStyle
{
    public $message;
    public $question;
    public $expectedSelector;

    public function ask($question, $default = null, $validator = null)
    {
        $this->question = $question;
        return $this->expectedSelector;
    }
}

class TestMenu extends Menu
{
    public function injectSymfonyStyle(SymfonyStyle $style)
    {
        $this->io = $style;
    }

    public function getOptions()
    {
        return $this->optionMap;
    }

    public function getWrapper()
    {
        return $this->wrapper;
    }
}

class TestOutput extends Output
{
    // we'll spy on the lines being provided here
    public $output = '';

    /**
     * clear the output here because it's just a string we're storing in memory
     * for the test. Actual output doesn't get buffered like this, so we're really
     * testing that the menu produces the same result every time we render it.
     */
    public function clear()
    {
        $this->output = '';
    }

    public function write($messages, $newline = false, $options = 0)
    {
    }

    public function writeln($messages, $options = 0)
    {
        foreach ((array) $messages as $message) {
            $this->doWrite($message, PHP_EOL);
        }
    }

    protected function doWrite($message, $newline)
    {
        $this->output .= $message . $newline;
    }
}
