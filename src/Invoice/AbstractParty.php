<?php

namespace Radowoj\Invoicer\Invoice;

use Exception;
use InvalidArgumentException;

class AbstractParty implements PartyInterface
{

    protected $taxIdentificationNumber = null;

    protected $companyName = null;

    protected $personName = null;

    protected $street = null;

    protected $postCode = null;

    protected $city = null;

    protected $country = null;

    public function __construct(array $data = [])
    {
        $this->fromArray($data);
    }


    public function isCompany() : bool
    {
        return (bool)($this->companyName !== '' && $this->taxIdentificationNumber !== '');
    }


    protected function getRequiredProperties()
    {
        return [
            'taxIdentificationNumber',
            'companyName',
            'personName',
            'street',
            'postCode',
            'city',
            'country'
        ];
    }


    public function fromArray(array $data)
    {
        $this->assertArrayContainsAllRequiredProperties($data);
        foreach($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }


    /**
     * @param array $data
     */
    protected function assertArrayContainsAllRequiredProperties(array $data): void
    {
        $missingProperties = [];
        foreach ($this->getRequiredProperties() as $property) {
            if (!array_key_exists($property, $data)) {
                $missingProperties[] = $property;
            }
        }

        if ($missingProperties) {
            throw new InvalidArgumentException('Missing properties: ' . implode(', ', $missingProperties));
        }
    }


    /**
     * @return string tax identification number
     */
    public function getTaxIdentificationNumber() : string
    {
        if (is_null($this->taxIdentificationNumber)) {
            throw new Exception('Tax identification number has not been set');
        }
        return $this->taxIdentificationNumber;
    }


    /**
     * @return string company name
     */
    public function getCompanyName() : string
    {
        if (is_null($this->companyName)) {
            throw new Exception('Company name has not been set');
        }
        return $this->companyName;
    }


    /**
     * @return string person name and surname
     */
    public function getPersonName() : string
    {
        if (is_null($this->personName)) {
            throw new Exception('Person name has not been set');
        }
        return $this->personName;
    }


    /**
     * @return string street WITH number
     */
    public function getStreet() : string
    {
        if (is_null($this->street)) {
            throw new Exception('Street has not been set');
        }
        return $this->street;
    }


    /**
     * @return string post code
     */
    public function getPostCode() : string
    {
        if (is_null($this->postCode)) {
            throw new Exception('Post code has not been set');
        }
        return $this->postCode;
    }


    /**
     * @return string city
     */
    public function getCity() : string
    {
        if (is_null($this->city)) {
            throw new Exception('City has not been set');
        }
        return $this->city;
    }


    /**
     * @return string country
     */
    public function getCountry() : string
    {
        if (is_null($this->country)) {
            throw new Exception('Country has not been set');
        }
        return $this->country;
    }


    /**
     * @return bool
     */
    public function hasTaxIdentificationNumber(): bool
    {
        return !empty($this->taxIdentificationNumber);
    }


    /**
     * @return bool
     */
    public function hasCompanyName(): bool
    {
        return !empty($this->companyName);
    }


}