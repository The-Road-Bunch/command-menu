<?php declare(strict_types=1);


namespace CommandMenu\Tests;


use CommandMenu\Exception\DuplicateOptionException;
use CommandMenu\Menu;
use CommandMenu\Option;
use PHPUnit\Framework\TestCase;

class MenuTest extends TestCase
{
    public function testAddOption()
    {
        $menu = $this->getMenuSpy();
        $menu->addOption(OptionBuilder::create()->build());

        $this->assertCount(1, $menu->getOptions());
    }

    /**
     * @dataProvider optionProvider
     */
    public function testAddDuplicateOptionThrowsException(Option $optionOne, Option $optionTwo)
    {
        $this->expectException(DuplicateOptionException::class);

        $menu = new Menu();
        $menu->addOption($optionOne);
        $menu->addOption($optionTwo);
    }

    public function optionProvider()
    {
        // duplicate options
        yield [OptionBuilder::create()->build(), OptionBuilder::create()->build()];
        // same slug, different name
        yield [OptionBuilder::create()->withName(uniqid())->build(), OptionBuilder::create()->build()];
        // different slug, same name
        yield [OptionBuilder::create()->withSlug(uniqid())->build(), OptionBuilder::create()->build()];
    }

    private function getMenuSpy()
    {
        return new class extends Menu
        {
            public function getOptions(): array
            {
                return $this->options;
            }
        };
    }
}
