<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Connector;

interface ConnectorResponseInterface
{
    public function getStatusCode() : int;

    public function getStatusString() : string;

    public function getResourceIdentifier() : string;

    public function isSuccess() : bool;
}