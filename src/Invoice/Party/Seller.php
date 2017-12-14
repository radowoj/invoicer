<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Invoice\Party;

use Radowoj\Invoicer\Invoice\AbstractParty;

class Seller extends AbstractParty implements SellerInterface
{

    protected function getRequiredProperties()
    {
        return [
            'taxIdentificationNumber',
            'companyName',
            'street',
            'postCode',
            'city',
            'country'
        ];
    }
}