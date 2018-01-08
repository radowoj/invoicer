<?php

namespace Radowoj\Invoicer\Connector;


abstract class AbstractConnectorRequest implements ConnectorRequestInterface
{

    protected $endpoint = null;


    public function send() : ConnectorResponseInterface
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
     * This will differ between connectors (soap/rest/etc)
     * @return ConnectorResponseInterface
     */
    abstract protected function sendRequest(string $endpoint, $body) : ConnectorResponseInterface;


    /**
     * This will differ between connectors or even messages
     */
    abstract protected function getBody();

}