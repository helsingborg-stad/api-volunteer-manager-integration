<?php

namespace APIVolunteerManagerIntegration\Model\Generic;

use IteratorAggregate;
use Traversable;

/**
 * @template T
 * @template-implements IteratorAggregate<int, T>
 */
class Collection implements IteratorAggregate
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
}