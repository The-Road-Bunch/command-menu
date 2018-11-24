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


use Symfony\Component\Console\Input\Input;

class TestInput extends Input
{
    /**
     * Processes command line arguments.
     */
    protected function parse()
    {
        // TODO: Implement parse() method.
    }

    /**
     * Returns the first argument from the raw parameters (not parsed).
     *
     * @return string|null The value of the first argument or null otherwise
     */
    public function getFirstArgument()
    {
        // TODO: Implement getFirstArgument() method.
    }

    /**
     * Returns true if the raw parameters (not parsed) contain a value.
     *
     * This method is to be used to introspect the input parameters
     * before they have been validated. It must be used carefully.
     * Does not necessarily return the correct result for short options
     * when multiple flags are combined in the same option.
     *
     * @param string|array $values The values to look for in the raw parameters (can be an array)
     *
     * @return bool true if the value is contained in the raw parameters
     */
    public function hasParameterOption($values)
    {
        // TODO: Implement hasParameterOption() method.
    }

    /**
     * Returns the value of a raw option (not parsed).
     *
     * This method is to be used to introspect the input parameters
     * before they have been validated. It must be used carefully.
     * Does not necessarily return the correct result for short options
     * when multiple flags are combined in the same option.
     *
     * @param string|array $values  The value(s) to look for in the raw parameters (can be an array)
     * @param mixed        $default The default value to return if no result is found
     *
     * @return mixed The option value
     */
    public function getParameterOption($values, $default = false)
    {
        // TODO: Implement getParameterOption() method.
    }
}
