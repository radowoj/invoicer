<?php

namespace Radowoj\Invoicer\Connector\Fakturownia\Request;

use Radowoj\Invoicer\Connector\Fakturownia\Request;
use Radowoj\Invoicer\Invoice\Margin;
use Radowoj\Invoicer\Connector\ConnectorResponseInterface;
use Radowoj\Invoicer\Connector\Fakturownia\Response\IssueResponse;

class IssueMargin extends Request
{
    protected $endpoint = 'http://__USERNAME__.fakturownia.pl/invoices.json';

    protected $kind = 'vat_margin';

    public function __construct(Margin $invoice)
    {
        $this->invoice = $invoice;
    }


    /**
     * Creates response of class associated with this request type
     * @param array $response
     * @return ConnectorResponseInterface
     */
    protected function createResponse(array $response): ConnectorResponseInterface
    {
        return new IssueResponse($response);
    }
}