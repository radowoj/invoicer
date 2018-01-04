<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Connector\Fakturownia;


use Radowoj\Invoicer\Connector\AbstractConnectorResponse;
use Radowoj\Invoicer\Connector\ConnectorResponseInterface;

class Response extends AbstractConnectorResponse implements ConnectorResponseInterface
{

    const STATUS_CODE_OK = 0;
    const STATUS_CODE_ERROR = 1;

    protected $codeString = '';

    public function __construct(array $response)
    {
        if (isset($response['id'])) {
            $this->resourceIdentifier = $response['id'];
        }

        if (isset($response['code'])) {
            $this->codeString = $response['code'];
        }

        if (isset($response['message'])) {
            $this->statusString = $this->parseResponse($response);
        }
    }


    protected function parseResponse(array $response) : string
    {
        if (is_string($response['message'])) {
            return $response['message'];
        } elseif (is_array($response['message'])) {
            return json_encode($response['message']);
        }

        throw new \Exception('Invalid API response: ', print_r($response, true));
    }


    public function getStatusCode() : int
    {
        if ($this->codeString !== '') {
            return self::STATUS_CODE_ERROR;
        }

        return self::STATUS_CODE_OK;
    }


    public function isSuccess() : bool
    {
        return ($this->getStatusCode() === self::STATUS_CODE_OK);
    }

}