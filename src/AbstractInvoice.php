<?php

declare(strict_types=1);

namespace Radowoj\Invoicer;

use Exception;
use DateTime;
use InvalidArgumentException;
use Radowoj\Invoicer\Invoice\PositionInterface;
use Radowoj\Invoicer\Invoice\Party\SellerInterface;
use Radowoj\Invoicer\Invoice\Party\BuyerInterface;
use Radowoj\Invoicer\Invoice\Positions\CollectionInterface;
use Radowoj\Invoicer\Invoice\Positions\Collection;

abstract class AbstractInvoice implements InvoiceInterface
{
    const LANGUAGE_CODE_LENGTH = 2;

    /**
     * @var DateTime invoice date
     */
    protected $invoiceDate = null;

    /**
     * @var DateTime transaction date
     */
    protected $transactionDate = null;

    /**
     * @var SellerInterface
     */
    protected $seller = null;

    /**
     * @var BuyerInterface
     */
    protected $buyer = null;

    /**
     * @var Collection
     */
    protected $positions = null;

    /**
     * @var string
     */
    protected $placeOfIssue = null;

    /**
     * @var string
     */
    protected $languageCode = '';

    /**
     * @var string
     */
    protected $currency = null;

    /**
     * @var string
     */
    protected $foreignCurrency = null;

    /**
     * @var double
     */
    protected $exchangeRate = null;

    /**
     * @var string
     */
    protected $description = '';


    /**
     * @return string
     */
    public function getLanguageCode(): string
    {
        if ($this->languageCode === '') {
            throw new Exception('Language code has not been set');
        }
        return $this->languageCode;
    }


    /**
     * @param string $languageCode
     */
    public function setLanguageCode(string $languageCode)
    {
        if (strlen($languageCode) !== self::LANGUAGE_CODE_LENGTH) {
            throw new InvalidArgumentException('Language code should be ' . self::LANGUAGE_CODE_LENGTH . ' characters long');
        }
        $this->languageCode = $languageCode;
    }


    /**
     * @return bool
     */
    public function hasLanguageCode() : bool
    {
        return !is_null($this->languageCode);
    }


    /**
     * @return string
     */
    public function getForeignCurrency(): string
    {
        if (is_null($this->foreignCurrency)) {
            throw new Exception('Currency has not been set');
        }

        return $this->foreignCurrency;
    }


    /**
     * @param string
     */
    public function setForeignCurrency(string $foreignCurrency) : InvoiceInterface
    {
        $this->foreignCurrency = $foreignCurrency;
        return $this;
    }


    /**
     * @return string
     */
    public function getCurrency(): string
    {
        if (is_null($this->currency)) {
            throw new Exception('Currency has not been set');
        }

        return $this->currency;
    }


    /**
     * @param string $currency
     * @return AbstractInvoice
     */
    public function setCurrency(string $currency): InvoiceInterface
    {
        $this->currency = $currency;
        return $this;
    }


    /**
     * @return string
     */
    public function getPlaceOfIssue(): string
    {
        if (is_null($this->placeOfIssue)) {
            throw new Exception("Place of issue has not been set");
        }
        return $this->placeOfIssue;
    }


    /**
     * @param string $placeOfIssue
     * @return InvoiceInterface
     */
    public function setPlaceOfIssue(string $placeOfIssue) : InvoiceInterface
    {
        $this->placeOfIssue = $placeOfIssue;
        return $this;
    }


    /**
     * @param string $invoiceDate
     * @return InvoiceInterface
     * @throws InvalidArgumentException when $invoiceDate provided is invalid
     */
    public function setInvoiceDate(DateTime $invoiceDate) : InvoiceInterface
    {
        $this->invoiceDate = $invoiceDate;
        return $this;
    }


    /**
     * @param string $format date format
     * @return string issue date of the invoice
     * @throws Exception when trying to get a date that has not been set earlier
     */
    public function getInvoiceDate() : DateTime
    {
        if (is_null($this->invoiceDate)) {
            throw new Exception("Invoice date has not been set");
        }
        return $this->invoiceDate;
    }


    /**
     * @param string $transactionDate
     * @return InvoiceInterface
     * @throws Exception when transactionDate provided is invalid
     */
    public function setTransactionDate(DateTime $transactionDate) : InvoiceInterface
    {
        $this->transactionDate = $transactionDate;
        return $this;
    }


    /**
     * @param string $format date format
     * @return string date of transaction related to this invoice
     * @throws Exception when trying to get a date that has not been set earlier
     */
    public function getTransactionDate() : DateTime
    {
        if (is_null($this->transactionDate)) {
            throw new Exception('Transaction date has not been set');
        }
        return $this->transactionDate;
    }


    /**
     * @param SellerInterface $seller
     * @return InvoiceInterface fluent interface
     */
    public function setSeller(SellerInterface $seller) : InvoiceInterface
    {
        $this->seller = $seller;
        return $this;
    }


    /**
     * @return SellerInterface
     */
    public function getSeller() : SellerInterface
    {
        if (is_null($this->seller)) {
            throw new Exception('Seller has not been set');
        }

        return $this->seller;
    }


    /**
     * @param BuyerInterface $buyer
     * @return InvoiceInterface fluent interface
     */
    public function setBuyer(BuyerInterface $buyer) : InvoiceInterface
    {
        $this->buyer = $buyer;
        return $this;
    }


    /**
     * @return BuyerInterface
     */
    public function getBuyer() : BuyerInterface
    {
        if (is_null($this->buyer)) {
            throw new Exception('Buyer has not been set');
        }

        return $this->buyer;
    }


    /**
     * @param Collection $positions
     * @return InvoiceInterface
     */
    public function setPositions(Collection $positions) : InvoiceInterface
    {
        $this->positions = $positions;
        return $this;
    }


    /**
     * @return CollectionInterface
     */
    public function getPositions() : CollectionInterface
    {
        $this->assertPositionsCollectionIsSet();
        return $this->positions;
    }


    /**
     * @param PositionInterface $position
     * @return InvoiceInterface fluent interface
     */
    public function addPosition(PositionInterface $position) : InvoiceInterface
    {
        $this->assertPositionsCollectionIsSet();
        $this->positions->add($position);
        return $this;
    }


    /**
     * @return string (decimal) net invoice total
     */
    public function getInvoiceNetTotal() : string
    {
        $this->assertPositionsCollectionIsSet();
        return $this->positions->getNetTotal();
    }


    /**
     * @return string (decimal) net invoice total
     */
    public function getInvoiceGrossTotal() : string
    {
        $this->assertPositionsCollectionIsSet();
        return $this->positions->getGrossTotal();
    }


    /**
     * @throws Exception when positions object is not set
     */
    protected function assertPositionsCollectionIsSet()
    {
        if (!$this->positions instanceof CollectionInterface) {
            throw new Exception('Invoice positions collection has not been set');
        }
    }


    /**
     * @return float
     */
    public function getExchangeRate(): float
    {
        if (is_null($this->exchangeRate)) {
            throw new Exception('Exchange rate has not been set');
        }
        return $this->exchangeRate;
    }


    /**
     * @param float $exchangeRate
     * @return Currency
     */
    public function setExchangeRate(float $exchangeRate): InvoiceInterface
    {
        $this->exchangeRate = $exchangeRate;
        return $this;
    }


    /**
     * @return bool
     */
    public function hasForeignCurrency()
    {
        return !is_null($this->foreignCurrency);
    }


    /**
     * @return bool
     */
    public function hasCurrency()
    {
        return !is_null($this->currency);
    }


    /**
     * @return bool
     */
    public function hasExchangeRate()
    {
        return !is_null($this->exchangeRate);
    }


    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * @param string $description
     * @return AbstractInvoice
     */
    public function setDescription(string $description): InvoiceInterface
    {
        $this->description = $description;
        return $this;
    }

}

