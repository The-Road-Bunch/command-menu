<?php declare(strict_types=1);


namespace RoadBunch\Tests\CommandMenu;


use RoadBunch\CommandMenu\Exception\DuplicateOptionException;
use RoadBunch\CommandMenu\Menu;
use RoadBunch\CommandMenu\Option;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

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
        // same slug, different name
        yield [OptionBuilder::create()->withName(uniqid())->build(), OptionBuilder::create()->build()];
        // different slug, same name
        yield [OptionBuilder::create()->withSlug(uniqid())->build(), OptionBuilder::create()->build()];
    }

    public function testRenderDefaultMenu()
    {
        $option  = OptionBuilder::create()->withName("Frank")->withSlug('option_frank')->build();
        $option2 = OptionBuilder::create()->withName("Charlie")->withSlug('option_charlie')->build();

        $this->menu->addOption($option);
        $this->menu->addOption($option2);

        $this->menu->render();
        $output = $this->output->output;

        $this->assertContains($option->name, $output);
        $this->assertContains($option2->name, $output);
    }
}
