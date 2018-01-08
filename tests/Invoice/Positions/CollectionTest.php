<?php

namespace Radowoj\Invoicer\Tests\Invoice\Positions;

use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;
use Radowoj\Invoicer\Invoice\Positions\Collection;
use Radowoj\Invoicer\Invoice\Position;
use Radowoj\Invoicer\Invoice\Positions\CollectionInterface;

class CollectionTest extends TestCase
{

    public function testIsCreated()
    {
        $collection = new Collection();
        $this->assertInstanceOf(CollectionInterface::class, $collection);
    }


    public function testAdd()
    {
        $collection = new Collection();

        $this->assertEquals(0, $collection->count());

        $positionMock = $this->getMockBuilder(Position::class)->getMock();
        $collection->add($positionMock);

        $this->assertEquals(1, $collection->count());

        $this->assertSame($positionMock, $collection[0]);
    }


    public function testGetNetTotal()
    {
        $collection = new Collection();

        $firstPositionMock = $this->getMockBuilder(Position::class)
        ->setMethods(['getNetTotalPrice'])
        ->getMock();

        $firstPositionMock->expects($this->once())
            ->method('getNetTotalPrice')
            ->willReturn(1.00);

        $secondPositionMock = $this->getMockBuilder(Position::class)
            ->setMethods(['getNetTotalPrice'])
            ->getMock();

        $secondPositionMock->expects($this->once())
            ->method('getNetTotalPrice')
            ->willReturn(2.00);

        $collection->add($firstPositionMock);
        $collection->add($secondPositionMock);

        $this->assertEquals('3.00', $collection->getNetTotal());
    }


    public function testGetGrossTotal()
    {
        $collection = new Collection();

        $firstPositionMock = $this->getMockBuilder(Position::class)
            ->setMethods(['getGrossTotalPrice'])
            ->getMock();

        $firstPositionMock->expects($this->once())
            ->method('getGrossTotalPrice')
            ->willReturn(1.00);

        $secondPositionMock = $this->getMockBuilder(Position::class)
            ->setMethods(['getGrossTotalPrice'])
            ->getMock();

        $secondPositionMock->expects($this->once())
            ->method('getGrossTotalPrice')
            ->willReturn(2.00);

        $collection->add($firstPositionMock);
        $collection->add($secondPositionMock);

        $this->assertEquals('3.00', $collection->getGrossTotal());
    }


    public function testOffsetExists()
    {
        $positionMock = $this->getMockBuilder(Position::class)->getMock();
        $collection = new Collection();
        $collection->add($positionMock);
        $this->assertTrue($collection->offsetExists(0));
        $this->assertFalse($collection->offsetExists(1));
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Direct offset setting/unsetting is not allowed
     */
    public function testExceptionOnOffsetSet()
    {
        $collection = new Collection();
        $collection[0] = 'setting an offset directly should not be allowed';
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Direct offset setting/unsetting is not allowed
     */
    public function testExceptionOnOffsetUnset()
    {
        $collection = new Collection();
        unset($collection[0]);
    }


    public function testGetIterator()
    {
        $collection = new Collection();

        $firstPositionMock = $this->getMockBuilder(Position::class)
            ->setMethods(['getGrossTotalPrice'])
            ->getMock();

        $secondPositionMock = $this->getMockBuilder(Position::class)
            ->setMethods(['getGrossTotalPrice'])
            ->getMock();

        $collection->add($firstPositionMock);
        $collection->add($secondPositionMock);

        $positionsInOrder = [$firstPositionMock, $secondPositionMock];

        foreach($collection as $index => $position) {
            $this->assertEquals($positionsInOrder[$index], $position);
        }
    }


}