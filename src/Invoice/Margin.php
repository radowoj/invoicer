<?php

namespace Radowoj\Invoicer\Invoice;

use DateTime;
use Radowoj\Invoicer\AbstractInvoice;
use Radowoj\Invoicer\Invoice\Party\BuyerInterface;
use Radowoj\Invoicer\Invoice\Party\SellerInterface;
use Radowoj\Invoicer\Invoice\Positions\Collection;

class Margin extends AbstractInvoice
{
    public function __construct(SellerInterface $seller, BuyerInterface $buyer, Collection $positions)
    {
        $this->setSeller($seller);
        $this->setBuyer($buyer);
        $this->setPositions($positions);
        $this->setInvoiceDate(new DateTime('now'));
        $this->setTransactionDate(new DateTime('now'));
    }
}