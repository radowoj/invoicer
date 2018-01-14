<?php

namespace Radowoj\Invoicer\Connector\Fakturownia\Request;


use Radowoj\Invoicer\Connector\Fakturownia\AbstractRequest;
use Radowoj\Invoicer\Invoice\Vat;


class IssueVat extends AbstractRequest
{
    protected $endpoint = 'http://__USERNAME__.fakturownia.pl/invoices.json';

    protected $kind = 'vat';

    public function __construct(Vat $invoice)
    {
        $this->invoice = $invoice;
    }

}