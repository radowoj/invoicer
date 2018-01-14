<?php

namespace Radowoj\Invoicer\Connector\Fakturownia\Request;

use Radowoj\Invoicer\Connector\Fakturownia\AbstractRequest;
use Radowoj\Invoicer\Invoice\Margin;

class IssueMargin extends AbstractRequest
{
    protected $endpoint = 'http://__USERNAME__.fakturownia.pl/invoices.json';

    protected $kind = 'vat_margin';

    public function __construct(Margin $invoice)
    {
        $this->invoice = $invoice;
    }



}