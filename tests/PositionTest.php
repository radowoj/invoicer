<?php

namespace Radowoj\Invoicer\Tests;


use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;
use Prophecy\Exception\InvalidArgumentException;
use Radowoj\Invoicer\Invoice\Position;

class PositionTest extends TestCase
{

    public function testNetUnitPrice()
    {
        $position = new Position();
        $position->setNetUnitPrice('1.23');
        $this->assertEquals('1.23', $position->getNetUnitPrice());
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Tax has not been set
     */
    public function testExceptionOnSettingGrossPriceWithoutTax()
    {
        $position = new Position();
        $position->setGrossUnitPrice('1.23');
    }


    public function testGrossUnitPrice()
    {
        $position = new Position();
        $position->setTaxRatePercent(0);
        $position->setGrossUnitPrice('1.23');
        $this->assertEquals('1.23', $position->getGrossUnitPrice() , 'Gross price fails for zero tax');

        $position = new Position();
        $position->setTaxRatePercent(23);
        $position->setGrossUnitPrice('2.97');
        $this->assertEquals('2.97', $position->getGrossUnitPrice(), 'Gross price fails for nonzero tax');
    }


    public function testTax()
    {
        $position = new Position();
        $position->setTaxRatePercent(23.0);
        $this->assertEquals(23.0, $position->getTaxRatePercent());
    }



    /**
     * Data provider for calculating from gross to net (gross is the point of truth)
     * @return array
     */
    public function providerNetToGross()
    {
        return [
            'nonzero tax one piece' => ['1.00', 23, '1.23', 1, '1.00', '1.23' ],
            'zero tax one piece' => ['1.00', 0, '1.00', 1, '1.00', '1.00'],
            'nonzero tax five pieces' => ['2.41', 23, '2.96', 5, '12.05', '14.80'
            ]
        ];
    }


    /**
     * @dataProvider providerNetToGross
     */
    public function testNetToGross(string $net, float $tax, string $expectedGross, int $quantity, string $expectedTotalNet, string $expectedTotalGross)
    {
        $position = new Position();
        $position->setTaxRatePercent($tax);
        $position->setNetUnitPrice($net);
        $position->setQuantity($quantity);
        $this->assertEquals($net, $position->getNetUnitPrice() , 'Net unit price is invalid');
        $this->assertEquals($expectedGross, $position->getGrossUnitPrice(), 'Gross unit price is invalid');
        $this->assertEquals($expectedTotalGross, $position->getGrossTotalPrice(), 'Gross total price is invalid');
        $this->assertEquals($expectedTotalNet, $position->getNetTotalPrice(), 'Gross total price is invalid');

    }


    /**
     * Data provider for calculating from gross to net (gross is the point of truth)
     * @return array
     */
    public function providerGrossToNet()
    {
        return [
            'nonzero tax one piece' => ['1.00', 23, '1.23', 1, '1.00', '1.23' ],
            'zero tax one piece' => ['1.00', 0, '1.00', 1, '1.00', '1.00'],
            'nonzero tax five pieces' => ['2.41', 23, '2.97', 5, '12.07', '14.85'
            ]
        ];
    }


    /**
     * @dataProvider providerGrossToNet
     */
    public function testGrossToNet(string $expectedNet, float $tax, string $gross, int $quantity, string $expectedTotalNet, string $expectedTotalGross)
    {
        $position = new Position();
        $position->setTaxRatePercent($tax);
        $position->setGrossUnitPrice($gross);
        $position->setQuantity($quantity);
        $this->assertEquals($gross, $position->getGrossUnitPrice() , 'Gross unit price is invalid');
        $this->assertEquals($expectedNet, $position->getNetUnitPrice(), 'Gross unit price is invalid');
        $this->assertEquals($expectedTotalGross, $position->getGrossTotalPrice(), 'Gross total price is invalid');
        $this->assertEquals($expectedTotalNet, $position->getNetTotalPrice(), 'Gross total price is invalid');
    }


    public function testTotalPrice()
    {
        $position = new Position();
        $position->setNetUnitPrice('1.00');
        $position->setQuantity(6);
        $this->assertEquals('6.00', $position->getNetTotalPrice());

        $position->setTaxRatePercent(25);
        $this->assertEquals('7.50', $position->getGrossTotalPrice());
    }


    public function testName()
    {
        $position = new Position();
        $position->setName('Tnettenba');
        $this->assertEquals('Tnettenba', $position->getName());
    }


    public function testUnit()
    {
        $position = new Position();
        $position->setUnit('some unit');
        $this->assertEquals('some unit', $position->getUnit());
    }


    public function testFluentInterface()
    {
        $position = new Position();
        $this->assertInstanceOf('Radowoj\Invoicer\Invoice\PositionInterface', $position->setUnit('some unit'));
        $this->assertInstanceOf('Radowoj\Invoicer\Invoice\PositionInterface', $position->setNetUnitPrice('1.00'));
        $this->assertInstanceOf('Radowoj\Invoicer\Invoice\PositionInterface', $position->setTaxRatePercent(25));

        $position = new Position();
        $this->assertInstanceOf('Radowoj\Invoicer\Invoice\PositionInterface', $position->setTaxRatePercent(25));
        $this->assertInstanceOf('Radowoj\Invoicer\Invoice\PositionInterface', $position->setGrossUnitPrice('1.25'));
        $this->assertInstanceOf('Radowoj\Invoicer\Invoice\PositionInterface', $position->setName('some name'));
        $this->assertInstanceOf('Radowoj\Invoicer\Invoice\PositionInterface', $position->setQuantity(13));
    }


    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Tax rate percent must be zero or greater
     */
    public function testExceptionOnNegativeTaxRatePercent()
    {
        $position = new Position();
        $position->setTaxRatePercent(-1);
    }


    public function testForeignUnit()
    {
        $position = new Position();
        $position->setForeignUnit('someUnit');
        $this->assertSame('someUnit', $position->getForeignUnit());
    }


    public function testForeignName()
    {
        $position = new Position();
        $position->setForeignName('someName');
        $this->assertSame('someName', $position->getForeignName());
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Price has already been set
     */
    public function testExceptionOnSettingAlreadySetPrice()
    {
        $position = new Position();
        $position->setNetUnitPrice(12.34);
        $position->setNetUnitPrice(12.34);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Price has not been set
     */
    public function testExceptionOnGettingNotSetPrice()
    {
        $position = new Position();
        $position->getNetUnitPrice();
    }


    public function testGetTaxRateDecimal()
    {
        $position = new Position();
        $position->setTaxRatePercent(12);
        $this->assertSame('0.12', (string)$position->getTaxRateDecimal());
    }

}