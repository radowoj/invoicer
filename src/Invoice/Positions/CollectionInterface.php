<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Invoice\Positions;

use Radowoj\Invoicer\Invoice\PositionInterface;

interface CollectionInterface
{
    public function add(PositionInterface $position) : CollectionInterface;

    public function getNetTotal() : string;

    public function getGrossTotal() : string;
}