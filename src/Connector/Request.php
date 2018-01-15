<?php

namespace Radowoj\Invoicer\Connector;


abstract class Request implements ConnectorRequestInterface
{

    /**
     * @var string|null Set in child class for specific request (or override getEndpoint() method)
     */
    protected $endpoint = null;


    final public function send() : ConnectorResponseInterface
    {
        return $this->sendRequest(
            $this->getEndpoint(),
            $this->getBody()
        );
    }


    protected function getEndpoint()
    {
        if (is_null($this->endpoint)) {
            throw new \Exception('Endpoint has not been set in ' . get_class($this));
        }
        return $this->endpoint;
    }


    /**
     * Request body
     * This will differ between connectors or even messages
     */
    abstract protected function getBody();


    /**
     * Creates our Response object based on array response from vendor
     * @param array $response
     * @return ConnectorResponseInterface
     */
    abstract protected function createResponse(array $response) : ConnectorResponseInterface;

}