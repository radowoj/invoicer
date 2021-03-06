<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Tests\Invoice;

use PHPUnit\Framework\TestCase;
use Radowoj\Invoicer\AbstractInvoice;
use Radowoj\Invoicer\Invoice\Margin;
use Radowoj\Invoicer\Invoice\Party\Seller;
use Radowoj\Invoicer\Invoice\Party\Buyer;
use Radowoj\Invoicer\Invoice\Positions\Collection;

class MarginTest extends TestCase
{

    public function testIsAnInvoice()
    {
        $sellerMock = $this->getMockBuilder(Seller::class)->getMock();
        $buyerMock = $this->getMockBuilder(Buyer::class)->getMock();
        $positionsMock = $this->getMockBuilder(Collection::class)->getMock();
        $object = new Margin($sellerMock, $buyerMock, $positionsMock);

        $this->assertInstanceOf(AbstractInvoice::class, $object, 'Margin invoice must be an invoice');
    }
}