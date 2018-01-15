<?php
/**
 * @author Radosław Wojtyczka <radoslaw.wojtyczka@gmail.com>
 */

namespace Radowoj\Invoicer\Connector;


interface IssueResponseInterface extends ConnectorResponseInterface
{
    /**
     * @return string
     */
    public function getInvoiceNumber(): string;
}