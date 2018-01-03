<?php
/**
 * Created by PhpStorm.
 * User: k0nik
 * Date: 2017-11-12
 * Time: 09:03
 */

namespace Radowoj\Invoicer\Tests;

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

    public function setUp()
    {
        $this->object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [],
            '',
            false
        );
    }


    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Missing properties
     */
    public function testFromEmptyArray()
    {
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


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Tax identification number has not been set
     */
    public function testExceptionOnGettingNotSetTaxIdentificationNumber()
    {
        $this->object->getTaxIdentificationNumber();
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Company name has not been set
     */
    public function testExceptionOnGettingNotSetCompanyName()
    {
        $this->object->getCompanyName();
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Person name has not been set
     */
    public function testExceptionOnGettingNotSetPersonName()
    {
        $this->object->getPersonName();
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Street has not been set
     */
    public function testExceptionOnGettingNotSetStreet()
    {
        $this->object->getStreet();
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Post code has not been set
     */
    public function testExceptionOnGettingNotSetPostCode()
    {
        $this->object->getPostCode();
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage City has not been set
     */
    public function testExceptionOnGettingNotSetCity()
    {
        $this->object->getCity();
    }


    /**
     * @expectedException Exception
     * @expectedExceptionMessage Country has not been set
     */
    public function testExceptionOnGettingNotSetCountry()
    {
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

        $this->assertTrue(true, $this->object->hasTaxIdentificationNumber());
    }


    public function testNegativeHasTaxIdentificationNumber()
    {
        $testPropertiesWithoutTaxId = $this->testProperties;
        $testPropertiesWithoutTaxId['taxIdentificationNumber'] = '';

        $this->object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [$testPropertiesWithoutTaxId]
        );

        $this->assertFalse(false, $this->object->hasTaxIdentificationNumber());
    }

    public function testPositiveHasCompanyName()
    {
        $this->object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [$this->testProperties]
        );

        $this->assertTrue(true, $this->object->hasCompanyName());
    }


    public function testNegativeHasCompanyName()
    {
        $testPropertiesWithoutCompanyName = $this->testProperties;
        $testPropertiesWithoutCompanyName['companyName'] = '';

        $this->object = $this->getMockForAbstractClass(
            AbstractParty::class,
            [$testPropertiesWithoutCompanyName]
        );

        $this->assertFalse(false, $this->object->hasCompanyName());
    }


}