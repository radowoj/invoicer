<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Connector;

use Radowoj\Invoicer\AbstractInvoice;

abstract class Connector
{
    abstract public function issue(AbstractInvoice $invoice): IssueResponseInterface;
}