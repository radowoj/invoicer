<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Tests;

use DateTime;
use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;
use Radowoj\Invoicer\AbstractInvoice;
use Radowoj\Invoicer\Invoice\Party\Buyer;
use Radowoj\Invoicer\Invoice\Party\Seller;
use Radowoj\Invoicer\Invoice\Positions\Collection;
use Radowoj\Invoicer\Invoice\Position;

class AbstractInvoiceTest extends TestCase
{

    public function testInvoiceDate()
    {
        //default format
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setInvoiceDate(new DateTime('2017-01-02'));
        $this->assertEquals(new DateTime('2017-01-02'), $object->getInvoiceDate(), 'Default format YYYY-MM-DD does not match');

        //fluent interface
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $returnValue = $object->setInvoiceDate(new DateTime('2001-01-01'));
        $this->assertInstanceOf('Radowoj\Invoicer\InvoiceInterface', $returnValue, 'setInvoiceDate() must return $this');
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invoice date has not been set
     */
    public function testExceptionOnGettingNotSetInvoiceDate()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->getInvoiceDate();
    }

    public function testTransactionDate()
    {
        //default format
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setTransactionDate(new DateTime('2017-01-02'));
        $this->assertEquals(new DateTime('2017-01-02'), $object->getTransactionDate(), 'Failed to set and get same transaction date');

        //fluent interface
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $returnValue = $object->setTransactionDate(new DateTime('2001-01-01'));
        $this->assertInstanceOf('Radowoj\Invoicer\InvoiceInterface', $returnValue, 'setInvoiceDate() must return $this');
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Transaction date has not been set
     */
    public function testExceptionOnGettingNotSetTransactionDate()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->getTransactionDate();
    }


    public function testBuyer()
    {
        $buyer = $this->getMockBuilder(Buyer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setBuyer($buyer);
        $this->assertSame($buyer, $object->getBuyer(), 'getBuyer() does not return the same object that has been set using setBuyer()');
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Buyer has not been set
     */
    public function testExceptionOnGettingNotSetBuyer()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->getBuyer();
    }


    public function testSeller()
    {
        $seller = $this->getMockBuilder(Seller::class)
            ->disableOriginalConstructor()
            ->getMock();

        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setSeller($seller);
        $this->assertSame($seller, $object->getSeller(), 'getSeller() does not return the same object that has been set using setSeller()');
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Seller has not been set
     */
    public function testExceptionOnGettingNotSetSeller()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->getSeller();
    }


    public function testPositions()
    {
        $positions = $this->getMockBuilder(Collection::class)
            ->getMock();

        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setPositions($positions);
        $this->assertSame($positions, $object->getPositions());
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invoice positions collection has not been set
     */
    public function testExceptionWhenAddingPositionWithoutPositionsSet()
    {
        $position = $this->getMockBuilder(Position::class)
            ->getMock();

        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->addPosition($position);
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invoice positions collection has not been set
     */
    public function testExceptionWhenGettingPositionsWithoutPositionsSet()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->getPositions();
    }


    public function testAddPosition()
    {
        $positions = $this->getMockBuilder(Collection::class)
            ->setMethods(['add'])
            ->getMock();

        $position = $this->getMockBuilder(Position::class)
            ->getMock();

        $positions->expects($this->once())
                ->method('add')
                ->with($this->equalTo($position));

        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setPositions($positions);
        $object->addPosition($position);
    }


    public function testGetInvoiceNetTotal()
    {
        $positions = $this->getMockBuilder(Collection::class)
            ->setMethods(['getNetTotal'])
            ->getMock();

        $positions->expects($this->once())
            ->method('getNetTotal')
            ->willReturn('12.34');

        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setPositions($positions);
        $this->assertEquals('12.34', $object->getInvoiceNetTotal(), 'getInvoiceTotal() does not return value returned by positions collection');
    }


    public function testGetInvoiceGrossTotal()
    {
        $positions = $this->getMockBuilder(Collection::class)
            ->setMethods(['getGrossTotal'])
            ->getMock();

        $positions->expects($this->once())
            ->method('getGrossTotal')
            ->willReturn('12.34');


        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setPositions($positions);
        $this->assertEquals('12.34', $object->getInvoiceGrossTotal(), 'getInvoiceTotal() does not return value returned by positions collection');
    }


    public function testPlaceOfIssue()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setPlaceOfIssue('Some city');
        $this->assertEquals('Some city', $object->getPlaceOfIssue());

        $object->setPlaceOfIssue('Some other city');
        $this->assertEquals('Some other city', $object->getPlaceOfIssue());
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Place of issue has not been set
     */
    public function testExceptionOnGettingNotSetPlaceOfIssue()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->getPlaceOfIssue();
    }




}