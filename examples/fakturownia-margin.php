<?php

declare(strict_types=1);

require_once('../vendor/autoload.php');
$config = require_once('config.php');

use Radowoj\Invoicer\Invoice\Party\Seller;
use Radowoj\Invoicer\Invoice\Party\Buyer;
use Radowoj\Invoicer\Invoice\Positions\Collection;
use Radowoj\Invoicer\Invoice\Position;

$seller = new Seller([
    'companyName' => 'Januszpol sp. z o.o.',
    'taxIdentificationNumber' => '5824502734',
    'street' => 'Asfaltowa 123/4',
    'postCode' => '12-345',
    'city' => 'Miasto',
    'country' => 'Polska',
]);

$buyer = new Buyer([
    'companyName' => 'Some Company',
    'taxIdentificationNumber' => '5824502734',
    'personName' => 'Gżdyl Grząślik',
    'street' => 'Brukowa 432/1',
    'postCode' => '54-321',
    'city' => 'Mniejsze Miasto',
    'country' => 'Polska',
]);

$positions = new Collection();

$position = new Position();
$position->setName('Pozycja faktury za dychę netto')
    ->setTaxRatePercent(23)
    ->setNetUnitPrice('10.00')
    ->setQuantity(5)
    ->setUnit('szt.');
$positions->add($position);

$position = new Position();
$position->setName('Pozycja faktury za sto osiem brutto')
    ->setTaxRatePercent(8)
    ->setNetUnitPrice('100.00')
    ->setQuantity(1)
    ->setUnit('szt.');
$positions->add($position);

$marginInvoice = new \Radowoj\Invoicer\Invoice\Margin($seller, $buyer, $positions);
$marginInvoice->setPlaceOfIssue('Wąchock');
$marginInvoice->setTransactionDate(new DateTime('2017-12-01'));
$marginInvoice->setDescription('Lorem ipsum dolor');
$marginInvoice->setLanguageCode('EN');

$fakturowniaConnector = new \Radowoj\Invoicer\Connector\Fakturownia\Connector([]);
$fakturowniaConnector->setToken($config['fakturownia']['token'])
    ->setUsername($config['fakturownia']['username']);
$response = $fakturowniaConnector->issue($marginInvoice);


echo "Całkowita cena netto: {$marginInvoice->getInvoiceNetTotal()}\n";
echo "Całkowita cena brutto: {$marginInvoice->getInvoiceGrossTotal()}\n";
echo "Kod odpowiedzi API: {$response->getStatusCode()}\n";
echo "Odpowiedź API: {$response->getStatusString()}\n";
echo "Identyfikator zasobu: {$response->getResourceIdentifier()}\n";