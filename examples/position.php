<?php
declare(strict_types=1);

require_once('../vendor/autoload.php');

$position = new \Radowoj\Invoicer\Invoice\Position();
//$position->setNetUnitPrice('2.41');
$position->setTaxRatePercent(23);
$position->setGrossUnitPrice('2.97');
var_dump($position->getNetUnitPrice(), $position->getGrossUnitPrice());
