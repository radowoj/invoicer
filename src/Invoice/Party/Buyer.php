<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Invoice\Party;

use Radowoj\Invoicer\Invoice\AbstractParty;

class Buyer extends AbstractParty implements BuyerInterface
{

    protected function getRequiredProperties()
    {
        return [
            'personName',
            'street',
            'postCode',
            'city',
            'country'
        ];
    }
}