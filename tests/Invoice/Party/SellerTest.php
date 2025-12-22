<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Tests\Invoice\Party;

use PHPUnit\Framework\TestCase;
use Radowoj\Invoicer\Invoice\Party\Seller;
use Radowoj\Invoicer\Invoice\Party\SellerInterface;

class SellerTest extends TestCase
{

    public function testIsCreated()
    {
        $seller = new Seller([
            'companyName' => 'Some company',
            'taxIdentificationNumber' => '123-456-78-90',
            'street' => 'Asphalt Street',
            'postCode' => '12-345',
            'city' => 'Some city',
            'country' => 'Some country',
        ]);
        $this->assertInstanceOf(SellerInterface::class, $seller);
    }


    public function testPersonNameIsRequired()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing properties: taxIdentificationNumber, companyName, street, postCode, city, country');
        
        new Seller([]);
    }

}
