<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Invoice;


interface PositionInterface
{
    public function setTaxRatePercent(float $tax) : PositionInterface;

    public function getTaxRatePercent() : float;

    public function getTaxRateDecimal(int $precision) : float;

    public function setQuantity(int $quantity): PositionInterface;

    public function getQuantity() : int;

    public function setGrossUnitPrice(string $unitPrice) : PositionInterface;

    public function getGrossUnitPrice() : string;

    public function setNetUnitPrice(string $unitPrice) : PositionInterface;

    public function getNetUnitPrice() : string;

    public function setName(string $name) : PositionInterface;

    public function getName() : string;

    public function setUnit(string $unit) : PositionInterface;

    public function getUnit() : string;

    public function getGrossTotalPrice() : string;

    public function getNetTotalPrice() : string;

}