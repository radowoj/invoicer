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


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invoice date has not been set
     */
    public function testExceptionOnGettingDueDateWithoutTransactionDate()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->getDueDate();
    }


    public function testDueDateDefaultsToInvoiceDate()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setInvoiceDate(new DateTime('2017-01-01'));
        $this->assertEquals(new DateTime('2017-01-01'), $object->getDueDate());
    }


    public function testDueDate()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setDueDate(new DateTime('2017-02-01'));
        $this->assertEquals(new DateTime('2017-02-01'), $object->getDueDate());

        //fluent interface
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $returnValue = $object->setDueDate(new DateTime('2001-01-01'));
        $this->assertInstanceOf('Radowoj\Invoicer\InvoiceInterface', $returnValue, 'setDueDate() must return $this');
    }


    public function testExchangeRate()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setExchangeRate(1.23);
        $this->assertEquals(1.23, $object->getExchangeRate());

        //fluent interface
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $returnValue = $object->setExchangeRate(1.23);
        $this->assertInstanceOf('Radowoj\Invoicer\InvoiceInterface', $returnValue, 'setExchangeRate() must return $this');
    }

    public function testHasExchangeRate()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $this->assertFalse($object->hasExchangeRate());

        $object->setExchangeRate(1.23);
        $this->assertTrue($object->hasExchangeRate());
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Exchange rate has not been set
     */
    public function testExceptionOnGettingNotSetExchangeRate()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->getExchangeRate();
    }


    public function testLanguageCode()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setLanguageCode('DJ');
        $this->assertEquals('DJ', $object->getLanguageCode());

        //fluent interface
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $returnValue = $object->setLanguageCode('DJ');
        $this->assertInstanceOf('Radowoj\Invoicer\InvoiceInterface', $returnValue, 'setLanguageCode() must return $this');
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Language code has not been set
     */
    public function testExceptionOnGettingNotSetLanguageCode()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->getLanguageCode();
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Language code should be 2 characters long
     */
    public function testExceptionOnInvalidLanguageCode()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setLanguageCode('Too long value for a language code');
    }


    public function testHasLanguageCode()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $this->assertFalse($object->hasLanguageCode());

        $object->setLanguageCode('DJ');
        $this->assertTrue($object->hasLanguageCode());
    }


    public function testCurrency()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setCurrency('PLN');
        $this->assertEquals('PLN', $object->getCurrency());

        //fluent interface
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $returnValue = $object->setCurrency('PLN');
        $this->assertInstanceOf('Radowoj\Invoicer\InvoiceInterface', $returnValue, 'setCurrency() must return $this');
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Currency has not been set
     */
    public function testExceptionOnGettingNotSetCurrency()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->getCurrency();
    }

    public function testHasCurrency()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $this->assertFalse($object->hasCurrency());

        $object->setCurrency('EUR');
        $this->assertTrue($object->hasCurrency());
    }

    public function testForeignCurrency()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setForeignCurrency('PLN');
        $this->assertEquals('PLN', $object->getForeignCurrency());

        //fluent interface
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $returnValue = $object->setForeignCurrency('PLN');
        $this->assertInstanceOf('Radowoj\Invoicer\InvoiceInterface', $returnValue, 'setForeignCurrency() must return $this');
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Foreign currency has not been set
     */
    public function testExceptionOnGettingNotSetForeignCurrency()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->getForeignCurrency();
    }


    public function testHasForeignCurrency()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $this->assertFalse($object->hasForeignCurrency());

        $object->setForeignCurrency('EUR');
        $this->assertTrue($object->hasForeignCurrency());
    }


    public function testDescription()
    {
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $object->setDescription('Some description');
        $this->assertEquals('Some description', $object->getDescription());

        //fluent interface
        $object = $this->getMockForAbstractClass(AbstractInvoice::class);
        $returnValue = $object->setDescription('Some description');
        $this->assertInstanceOf('Radowoj\Invoicer\InvoiceInterface', $returnValue, 'setDescription() must return $this');
    }


}