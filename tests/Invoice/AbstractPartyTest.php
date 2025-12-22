<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Tests\Invoice;

use InvalidArgumentException;
use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;
use Radowoj\Invoicer\Invoice\AbstractParty;

class AbstractPartyTest extends TestCase
{

    /**
     * @var AbstractParty
     */
    protected $object = null;

    protected $testProperties = [
        'taxIdentificationNumber' => '1234-567-890',
        'companyName' => 'Some company',
        'personName' => 'Some person',
        'street' => 'Some street',
        'postCode' => '12-345',
        'city' => 'Some city',
        'country' => 'Some country'
    ];

    public function setUp(): void
    {
        $this->object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [],
            '',
            false
        );
    }


    public function testFromEmptyArray()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing properties');
        
        $this->object->fromArray([]);
    }



    public function testFromNonEmptyArray()
    {
        $this->object->fromArray($this->testProperties);

        $this->assertSame(
            $this->testProperties['taxIdentificationNumber'],
            $this->object->getTaxIdentificationNumber(),
            'Tax identification number is invalid'
        );

        $this->assertSame(
            $this->testProperties['companyName'],
            $this->object->getCompanyName(),
            'Company name is invalid'
        );

        $this->assertSame(
            $this->testProperties['personName'],
            $this->object->getPersonName(),
            'Tax identification number is invalid'
        );

        $this->assertSame(
            $this->testProperties['street'],
            $this->object->getStreet(),
            'Street is invalid'
        );

        $this->assertSame(
            $this->testProperties['postCode'],
            $this->object->getPostCode(),
            'Postcode is invalid'
        );

        $this->assertSame(
            $this->testProperties['city'],
            $this->object->getCity(),
            'City is invalid'
        );

        $this->assertSame(
            $this->testProperties['country'],
            $this->object->getCountry(),
            'Country is invalid'
        );
    }


    public function testExceptionOnGettingNotSetTaxIdentificationNumber()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Tax identification number has not been set');
        
        $this->object->getTaxIdentificationNumber();
    }


    public function testExceptionOnGettingNotSetCompanyName()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Company name has not been set');
        
        $this->object->getCompanyName();
    }


    public function testExceptionOnGettingNotSetPersonName()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Person name has not been set');
        
        $this->object->getPersonName();
    }


    public function testExceptionOnGettingNotSetStreet()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Street has not been set');
        
        $this->object->getStreet();
    }


    public function testExceptionOnGettingNotSetPostCode()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Post code has not been set');
        
        $this->object->getPostCode();
    }


    public function testExceptionOnGettingNotSetCity()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('City has not been set');
        
        $this->object->getCity();
    }


    public function testExceptionOnGettingNotSetCountry()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Country has not been set');
        
        $this->object->getCountry();
    }


    public function testIsCompanyWhenTaxIdentificationNumberAndCompanyNameAreSet()
    {
        $object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [],
            '',
            false
        );

        $allProperties = $this->testProperties;
        $object->fromArray($allProperties);
        $this->assertTrue($object->isCompany(), 'Should be a company when tax identification number and company name are set');
    }


    public function testIsNotCompanyWhenTaxIdentificationNumberIsNotSet()
    {
        $object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [],
            '',
            false
        );

        $allProperties = $this->testProperties;
        $allProperties['taxIdentificationNumber'] = '';
        $object->fromArray($allProperties);
        $this->assertFalse($object->isCompany(), 'Should not be a company when tax identification number is not set');

    }


    public function testIsNotCompanyWhenCompanyNameIsNotSet()
    {
        $object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [],
            '',
            false
        );

        $allProperties = $this->testProperties;
        $allProperties['companyName'] = '';
        $object->fromArray($allProperties);
        $this->assertFalse($object->isCompany(), 'Should not be a company when company name is not set');
   }


    public function testOriginalConstructor()
    {
        $this->object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [$this->testProperties]
        );

        $this->assertSame(
            $this->testProperties['taxIdentificationNumber'],
            $this->object->getTaxIdentificationNumber(),
            'Tax identification number is invalid'
        );

        $this->assertSame(
            $this->testProperties['companyName'],
            $this->object->getCompanyName(),
            'Company name is invalid'
        );

        $this->assertSame(
            $this->testProperties['personName'],
            $this->object->getPersonName(),
            'Person name'
        );

        $this->assertSame(
            $this->testProperties['street'],
            $this->object->getStreet(),
            'Street is invalid'
        );

        $this->assertSame(
            $this->testProperties['postCode'],
            $this->object->getPostCode(),
            'Postcode is invalid'
        );

        $this->assertSame(
            $this->testProperties['city'],
            $this->object->getCity(),
            'City is invalid'
        );

        $this->assertSame(
            $this->testProperties['country'],
            $this->object->getCountry(),
            'Country is invalid'
        );
    }


    public function testPositiveHasTaxIdentificationNumber()
    {
        $this->object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [$this->testProperties]
        );

        $this->assertEquals(true, $this->object->hasTaxIdentificationNumber());
    }


    public function testNegativeHasTaxIdentificationNumber()
    {
        $testPropertiesWithoutTaxId = $this->testProperties;
        $testPropertiesWithoutTaxId['taxIdentificationNumber'] = '';

        $this->object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [$testPropertiesWithoutTaxId]
        );

        $this->assertEquals(false, $this->object->hasTaxIdentificationNumber());
    }

    public function testPositiveHasCompanyName()
    {
        $this->object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [$this->testProperties]
        );

        $this->assertEquals(true, $this->object->hasCompanyName());
    }


    public function testNegativeHasCompanyName()
    {
        $testPropertiesWithoutCompanyName = $this->testProperties;
        $testPropertiesWithoutCompanyName['companyName'] = '';

        $this->object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [$testPropertiesWithoutCompanyName]
        );

        $this->assertEquals(false, $this->object->hasCompanyName());
    }


}
