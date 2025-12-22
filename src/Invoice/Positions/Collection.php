<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Invoice\Positions;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Exception;
use IteratorAggregate;
use Radowoj\Invoicer\Invoice\PositionInterface;
use Radowoj\Invoicer\Invoice\Traits\StringFloat;

class Collection implements CollectionInterface, ArrayAccess, IteratorAggregate, Countable
{

    use StringFloat;

    protected $positions = [];

    public function add(PositionInterface $position) : CollectionInterface
    {
        $this->positions[] = $position;
        return $this;
    }


    public function getNetTotal() : string
    {
        $total = 0;
        foreach($this->positions as $position) {
            $total += $position->getNetTotalPrice();
        }
        return $this->floatToString($total);
    }


    public function getGrossTotal() : string
    {
        $total = 0;
        foreach($this->positions as $position) {
            $total += $position->getGrossTotalPrice();
        }
        return $this->floatToString($total);
    }


    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->positions);
    }


    public function offsetGet($offset): mixed
    {
        return $this->positions[$offset];
    }


    public function offsetUnset($offset): void
    {
        throw new Exception("Direct offset setting/unsetting is not allowed");
    }


    public function offsetSet($offset, $value): void
    {
        throw new Exception("Direct offset setting/unsetting is not allowed, use Collection::add() instead");
    }


    public function getIterator(): \Iterator
    {
        return new ArrayIterator($this->positions);
    }


    public function count(): int
    {
        return count($this->positions);
    }


}
