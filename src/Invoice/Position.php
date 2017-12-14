<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Invoice;

use Exception;
use InvalidArgumentException;
use Radowoj\Invoicer\Invoice\Traits\StringFloat;

class Position implements PositionInterface
{

    use StringFloat;

    /**
     * @var null
     */
    protected $taxRatePercent = null;

    /**
     * @var int
     */
    protected $quantity = 0;

    /**
     * @var null
     */
    protected $netUnitPrice = null;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $foreignName = '';

    /**
     * @var string
     */
    protected $unit = '';

    /**
     * @var string
     */
    protected $foreignUnit = '';

    /**
     * @return string
     */
    public function getForeignName(): string
    {
        return $this->foreignName;
    }


    /**
     * @param string $foreignName
     * @return Position
     */
    public function setForeignName(string $foreignName): PositionInterface
    {
        $this->foreignName = $foreignName;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getForeignUnit()
    {
        return $this->foreignUnit;
    }


    /**
     * @param string $foreignUnit
     * @return Position
     */
    public function setForeignUnit(string $foreignUnit): PositionInterface
    {
        $this->foreignUnit = $foreignUnit;
        return $this;
    }


    /**
     * @return float
     */
    public function getTaxRatePercent() : float
    {
        if (is_null($this->taxRatePercent)) {
            throw new Exception('Tax has not been set');
        }

        return $this->taxRatePercent;
    }


    /**
     * @param int $precision
     * @return float
     * @throws Exception
     */
    public function getTaxRateDecimal(int $precision = 2): float
    {
        return round($this->getTaxRatePercent() / 100, $precision);
    }

    /**
     * @param float $tax
     * @return Position
     */
    public function setTaxRatePercent(float $taxRatePercent) : PositionInterface
    {
        if ($taxRatePercent < 0) {
            throw new InvalidArgumentException('Tax rate percent must be zero or greater');
        }
        $this->taxRatePercent = $taxRatePercent;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity() : int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return Position
     */
    public function setQuantity(int $quantity): PositionInterface
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return float
     * @throws Exception when price is not set
     */
    public function getNetUnitPrice(): string
    {
        $this->assertPriceIsSet();
        return $this->floatToString($this->netUnitPrice);
    }

    /**
     * @param float $unitPrice
     * @return Position
     * @throws Exception where price is already set
     */
    public function setNetUnitPrice(string $unitPrice) : PositionInterface
    {
        $this->assertPriceIsNotSet();
        $this->netUnitPrice = $this->stringToFloat($unitPrice);
        return $this;
    }


    /**
     * @return float
     * @throws Exception where price is not set
     */
    public function getGrossUnitPrice(): string
    {
        $this->assertPriceIsSet();
        return $this->floatToString(
            $this->netUnitPrice * $this->getTaxMultiplier()
        );
    }


    /**
     * @param float $unitPrice
     * @return Position
     * @throws Exception when price has already been set
     */
    public function setGrossUnitPrice(string $unitPrice) : PositionInterface
    {
        $this->assertPriceIsNotSet();
        $this->netUnitPrice = $this->stringToFloat($unitPrice) / $this->getTaxMultiplier();
        return $this;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param string $name
     * @return Position
     */
    public function setName(string $name) : PositionInterface
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }


    /**
     * @param string $unit
     * @return Position
     */
    public function setUnit(string $unit) : PositionInterface
    {
        $this->unit = $unit;
        return $this;
    }


    /**
     * @return string
     * @throws Exception
     */
    public function getGrossTotalPrice(): string
    {
        $this->assertPriceIsSet();
        return $this->floatToString(
            $this->getGrossUnitPrice() * $this->getQuantity()
        );
    }


    /**
     * @return string
     * @throws Exception
     */
    public function getNetTotalPrice() : string
    {
        $this->assertPriceIsSet();
        return $this->floatToString(
            $this->netUnitPrice * $this->getQuantity()
        );
    }


    /**
     * @return float
     * @throws Exception
     */
    protected function getTaxMultiplier() : float
    {
        return (100 + $this->getTaxRatePercent()) / 100;
    }


    /**
     * @throws Exception
     */
    protected function assertPriceIsSet()
    {
        if (is_null($this->netUnitPrice)) {
            throw new Exception('Price has not been set');
        }
    }


    /**
     * @throws Exception
     */
    protected function assertPriceIsNotSet()
    {
        if (!is_null($this->netUnitPrice)) {
            throw new Exception('Price has already been set');
        }
    }

}