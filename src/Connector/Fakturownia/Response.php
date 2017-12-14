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
            $this->statusString = $this->parseStatusString($response);
        }
    }


    protected function parseStatusString(array $response) : string
    {
        if (is_string($response['message'])) {
            return $response['message'];
        } elseif (is_array($response['message'])) {
            $errorsAssoc = array_map(function($errors){
               $errors = implode(", ", $errors);

               return preg_replace("/^\s*-\s*/", '', $errors);
            }, $response['message']);

            $return = '';
            foreach($errorsAssoc as $field => $errorsString) {
                $return .= "{$field}: {$errorsString}\n";
            }

            return $return;
        }
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
        return ($this->getStatusCode() === self::RETURN_CODE_OK);
    }

}