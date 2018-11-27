<?php
/**
 * This file is part of the theroadbunch/command-menu package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\CommandMenu;


use RoadBunch\Wrapper\WrapperInterface;

/**
 * Class Menu
 *
 * @author  Dan McAdams
 * @package RoadBunch\CommandMenu
 */
interface MenuInterface
{
    /**
     * Wrap menu selectors, eg. (q) or [q]
     *
     * @example
     *  Using new Wrapper('', ')');
     *
     * // output
     *
     * 1) Option
     * 2) Option
     * 3) Option
     *
     * @param WrapperInterface $wrapper
     */
    public function setSelectorWrapper(WrapperInterface $wrapper);

    /**
     * Add an option to the menu
     * If a selector is not provided, an incrementing integer will be assigned to the menu option
     *
     * @param string      $name
     * @param string      $label
     * @param string|null $selector
     */
    public function addOption(string $name, string $label, string $selector = null): void;

    /**
     * Set the menu options
     * This will override any options previously set or added
     *
     * @param Option[]|iterable $options
     */
    public function setOptions(iterable $options): void;

    /**
     * Adds a title to the menu.
     *
     * @param string $message
     */
    public function title(string $message): void;

    /**
     * Render the menu to output
     */
    public function render(): void;

    /**
     * Check the user input against the menu options
     *
     * @param $selection
     *
     * @return string   the name of the matching option if a selection was made
     * @return null     if no option matches the selection
     */
    public function select($selection): ?string;

    /**
     * Sets expectation of input from the user
     * returns the name of the selected menu option
     *
     * @param string $prompt
     *
     * @return string   the name of the matching option if a selection was made
     * @return null     if no option matches the selection
     */
    public function selectFromUserInput(string $prompt): ?string;
}
