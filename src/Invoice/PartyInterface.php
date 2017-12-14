<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Invoice;

interface PartyInterface
{

    /**
     * @return bool
     */
    public function hasTaxIdentificationNumber() : bool;

    /**
     * @return string tax identification number
     */
    public function getTaxIdentificationNumber() : string;

    /**
     * @return bool
     */
    public function hasCompanyname() : bool;

    /**
     * @return string company name
     */
    public function getCompanyName() : string;

    /**
     * @return string person name and surname
     */
    public function getPersonName() : string;

    /**
     * @return string street WITH number
     */
    public function getStreet() : string;

    /**
     * @return string post code
     */
    public function getPostCode() : string;

    /**
     * @return string city
     */
    public function getCity() : string;

    /**
     * @return string country
     */
    public function getCountry() : string;

    /**
     * @return bool
     */
    public function isCompany() : bool;

}
