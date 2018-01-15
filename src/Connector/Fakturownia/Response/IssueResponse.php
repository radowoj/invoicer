<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Connector\Fakturownia\Response;

use Radowoj\Invoicer\Connector\Fakturownia\Response;
use Radowoj\Invoicer\Connector\IssueResponseInterface;

class IssueResponse extends Response implements IssueResponseInterface
{
    /**
     * @var string
     */
    protected $invoiceNumber = '';

    public function __construct(array $response)
    {
        parent::__construct($response);
        if (isset($response['number'])) {
            $this->invoiceNumber = $response['number'];
        }
    }


    /**
     * @return string
     */
    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }


}