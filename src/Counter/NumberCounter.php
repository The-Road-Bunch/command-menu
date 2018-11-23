<?php declare(strict_types=1);

/**
 * This file is part of the theroadbunch/command-menu package.
 *
 * (c) Dan McAdams <danmcadams@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RoadBunch\Counter;


class NumberCounter
{
    protected $startNumber;
    protected $count;

    public function __construct(int $startNumber = 1)
    {
        $this->startNumber = $startNumber;
        $this->reset();
    }

    /**
     * Get the next number in the sequence
     *
     * @return mixed
     */
    public function next()
    {
        return ++$this->count;
    }

    /**
     * Reset the counter to it's start position
     */
    public function reset()
    {
        $this->count = $this->startNumber - 1;
    }
}
