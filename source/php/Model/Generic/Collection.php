<?php

namespace APIVolunteerManagerIntegration\Model\Generic;

use ArrayAccess;
use IteratorAggregate;
use Traversable;

/**
 * @template T
 * @template-implements IteratorAggregate<int, T>
 * @template-implements ArrayAccess<int, T>
 */
class Collection implements IteratorAggregate, ArrayAccess
{
    private array $items;

    /**
     * @param  array<int, T>  $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return Traversable<int, T>
     */
    public function getIterator(): Traversable
    {
        yield from $this->items;
    }

    /**
     * Check if offset exists
     *
     * @param  int  $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * Get value at a specific offset
     *
     * @param  int  $offset
     *
     * @return T
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * Set value at a specific offset
     *
     * @param  int  $offset
     * @param  T  $value
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * Unset value at a specific offset
     *
     * @param  int  $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }
}