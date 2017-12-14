<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Connector\Fakturownia;

use Exception;
use Radowoj\Invoicer\Connector\AbstractConnectorRequest;
use Radowoj\Invoicer\Connector\ConnectorResponseInterface;

abstract class AbstractRequest extends AbstractConnectorRequest
{

    /**
     * @var string
     */
    protected $token = '';

    /**
     * @var string
     */
    protected $username = '';


    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token) : AbstractRequest
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        if ($this->username === '') {
            throw new Exception('Username has not been set');
        }
        return $this->username;
    }


    /**
     * @param string $username
     * @return AbstractRequest
     */
    public function setUsername(string $username): AbstractRequest
    {
        $this->username = $username;
        return $this;
    }




    public function sendRequest(string $endpoint, $body) : ConnectorResponseInterface
    {
        $body['api_token'] = $this->getToken();
        $json = json_encode($body);
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $endpoint);
        $head[] ='Accept: application/json';
        $head[] ='Content-Type: application/json';
        curl_setopt($c, CURLOPT_HTTPHEADER, $head);
        curl_setopt($c, CURLOPT_POSTFIELDS, $json);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($c);
        return new Response(json_decode($response, true));
    }


    protected function getEndpoint()
    {
        $endpoint = parent::getEndpoint();
        return str_replace('__USERNAME__', $this->getUsername(), $endpoint);
    }


    protected function getSeller()
    {
        $seller = $this->invoice->getSeller();
        return [
            'seller_name' => $seller->getCompanyName(),
            'seller_tax_no' => preg_replace('/[^0-9]/', '', $seller->getTaxIdentificationNumber()),
            'seller_post_code' => $seller->getPostCode(),
            'seller_city' => $seller->getCity(),
            'seller_street' => $seller->getStreet(),
            'seller_country' => $seller->getCountry(),
        ];
    }


    protected function getBuyer()
    {
        $buyer = $this->invoice->getBuyer();
        return [
            "buyer_name" => $buyer->hasCompanyName() ? $buyer->getCompanyName() : $buyer->getPersonName(),
            "buyer_tax_no" => $buyer->hasTaxIdentificationNumber() ? preg_replace('/[^0-9]/', '', $buyer->getTaxIdentificationNumber()) : '',
            "buyer_post_code" => $buyer->getPostCode(),
            "buyer_city" => $buyer->getCity(),
            "buyer_street" => $buyer->getStreet(),
            "buyer_country" => $buyer->getCountry(),
        ];
    }



}