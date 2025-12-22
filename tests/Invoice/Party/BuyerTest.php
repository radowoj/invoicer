<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Tests\Invoice\Party;

use PHPUnit\Framework\TestCase;
use Radowoj\Invoicer\Invoice\Party\Buyer;
use Radowoj\Invoicer\Invoice\Party\BuyerInterface;

class BuyerTest extends TestCase
{

    public function testIsCreated()
    {
        $buyer = new Buyer([
            'personName' => 'John Doe',
            'street' => 'Asphalt Street',
            'postCode' => '12-345',
            'city' => 'Some city',
            'country' => 'Some country',
        ]);
        $this->assertInstanceOf(BuyerInterface::class, $buyer);
    }


    public function testPersonNameIsRequired()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing properties: personName, street, postCode, city, country');
        
        new Buyer([]);
    }

}
