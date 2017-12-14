<?php

declare(strict_types=1);

namespace Radowoj\Invoicer;

use DateTime;
use Radowoj\Invoicer\Invoice\Party\SellerInterface;
use Radowoj\Invoicer\Invoice\Party\BuyerInterface;
use Radowoj\Invoicer\Invoice\Positions\CollectionInterface;
use Radowoj\Invoicer\Invoice\PositionInterface;

interface InvoiceInterface
{
    /**
     * @param string $format date format
     * @return string issue date of the invoice
     */
    public function getInvoiceDate() : DateTime;


    /**
     * @param string $format date format
     * @return string date of transaction related to this invoice
     */
    public function getTransactionDate() : DateTime;


    /**
     * @param SellerInterface $seller
     * @return InvoiceInterface fluent interface
     */
    public function setSeller(SellerInterface $seller) : InvoiceInterface;


    /**
     * @return SellerInterface
     */
    public function getSeller() : SellerInterface;


    /**
     * @param BuyerInterface $buyer
     * @return InvoiceInterface fluent interface
     */
    public function setBuyer(BuyerInterface $buyer) : InvoiceInterface;


    /**
     * @return BuyerInterface
     */
    public function getBuyer() : BuyerInterface;


    /**
     * @return CollectionInterface
     */
    public function getPositions() : CollectionInterface;


    /**
     * @param PositionInterface $position
     * @return InvoiceInterface fluent interface
     */
    public function addPosition(PositionInterface $position) : InvoiceInterface;


    /**
     * @return float net invoice total
     */
    public function getInvoiceNetTotal() : string;


    /**
     * @return float gross invoice total
     */
    public function getInvoiceGrossTotal() : string;

}