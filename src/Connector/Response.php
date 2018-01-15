<?php


namespace Radowoj\Invoicer\Connector;


abstract class Response implements ConnectorResponseInterface
{

    /**
     * @var string
     */
    protected $resourceIdentifier = '';

    /**
     * @var int
     */
    protected $statusCode = '';

    /**
     * @var string
     */
    protected $statusString = '';

    /**
     * @return string
     */
    public function getResourceIdentifier(): string
    {
        return $this->resourceIdentifier;
    }

    /**
     * @return string
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getStatusString(): string
    {
        return $this->statusString;
    }


    abstract public function isSuccess(): bool;

}