<?php

namespace Radowoj\Invoicer\Connector\Fakturownia\Request;

use Radowoj\Invoicer\Connector\ConnectorResponseInterface;
use Radowoj\Invoicer\Connector\Fakturownia\Request;
use Radowoj\Invoicer\Connector\Fakturownia\Response\IssueResponse;
use Radowoj\Invoicer\Invoice\Vat;

class IssueVat extends Request
{
    protected $endpoint = 'https://__USERNAME__.fakturownia.pl/invoices.json';

    protected $kind = 'vat';

    public function __construct(Vat $invoice)
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
