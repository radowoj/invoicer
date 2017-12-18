<?php
/**
 * @author Radosław Wojtyczka <radoslaw.wojtyczka@gmail.com>
 */

namespace Radowoj\Invoicer;

use DateTime;
use Radowoj\Invoicer\Invoice\Party\BuyerInterface;
use Radowoj\Invoicer\Invoice\Party\SellerInterface;
use Radowoj\Invoicer\Invoice\PositionInterface;
use Radowoj\Invoicer\Invoice\Positions\Collection;
use Radowoj\Invoicer\Invoice\Positions\CollectionInterface;

interface InvoiceInterface
{
    public function getLanguageCode(): string;

    public function setLanguageCode(string $languageCode);

    public function hasLanguageCode(): bool;

    public function getForeignCurrency(): string;

    public function setForeignCurrency(string $foreignCurrency): InvoiceInterface;

    public function getCurrency(): string;

    public function setCurrency(string $currency): InvoiceInterface;

    public function getPlaceOfIssue(): string;

    public function setPlaceOfIssue(string $placeOfIssue): InvoiceInterface;

    public function setInvoiceDate(DateTime $invoiceDate): InvoiceInterface;

    public function getInvoiceDate(): DateTime;

    public function setTransactionDate(DateTime $transactionDate): InvoiceInterface;

    public function getTransactionDate(): DateTime;

    public function setSeller(SellerInterface $seller): InvoiceInterface;

    public function getSeller(): SellerInterface;

    public function setBuyer(BuyerInterface $buyer): InvoiceInterface;

    public function getBuyer(): BuyerInterface;

    public function setPositions(Collection $positions): InvoiceInterface;

    public function getPositions(): CollectionInterface;

    public function addPosition(PositionInterface $position): InvoiceInterface;

    public function getInvoiceNetTotal(): string;

    public function getInvoiceGrossTotal(): string;

    public function getExchangeRate(): float;

    public function setExchangeRate(float $exchangeRate): InvoiceInterface;

    public function hasForeignCurrency();

    public function hasCurrency();

    public function hasExchangeRate();

    public function getDescription(): string;

    public function setDescription(string $description): InvoiceInterface;
}