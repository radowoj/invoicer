<?php

namespace Radowoj\Invoicer\Invoice;

use DateTime;
use Radowoj\Invoicer\AbstractInvoice;
use Radowoj\Invoicer\Invoice\Party\BuyerInterface;
use Radowoj\Invoicer\Invoice\Party\SellerInterface;
use Radowoj\Invoicer\Invoice\Positions\Collection;

class Vat extends AbstractInvoice
{

    public function __construct(SellerInterface $seller, BuyerInterface $buyer, Collection $positions, DateTime $invoiceDate = null, DateTime $transactionDate = null)
    {
        if (is_null($invoiceDate)) {
            $invoiceDate = new DateTime('now');
        }

        if (is_null($transactionDate)) {
            $transactionDate = new DateTime('now');
        }

        $this->setSeller($seller);
        $this->setBuyer($buyer);
        $this->setPositions($positions);
        $this->setInvoiceDate($invoiceDate);
        $this->setTransactionDate($transactionDate);
    }


}