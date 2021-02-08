<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Connector\Fakturownia;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Radowoj\Invoicer\Connector\Fakturownia\Response\IssueResponse;
use Radowoj\Invoicer\Connector\Request as BaseAbstractRequest;
use Radowoj\Invoicer\Connector\ConnectorResponseInterface;
use Radowoj\Invoicer\Invoice\Party\BuyerInterface;
use Radowoj\Invoicer\InvoiceInterface;

abstract class Request extends BaseAbstractRequest
{

    /**
     * @var Client
     */
    protected $client = null;

    /**
     * @var InvoiceInterface | null
     */
    protected $invoice = null;

    /**
     * @var string
     */
    protected $token = '';

    /**
     * @var string
     */
    protected $username = '';


    /**
     * @var string
     */
    protected $kind = '';


    /**
     * Return invoice kind
     * @return string
     * @throws Exception when kind has not been properly set
     */
    protected function getKind()
    {
        if ($this->kind === '') {
            throw new Exception('Invoice kind must not be empty string');
        }
        return $this->kind;
    }


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
    public function setToken(string $token): Request
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
     * @return Request
     */
    public function setUsername(string $username): Request
    {
        $this->username = $username;
        return $this;
    }


    public function sendRequest(string $endpoint, $body): ConnectorResponseInterface
    {
        $body['api_token'] = $this->getToken();

        $response = $this->getClient()->post($endpoint, [
            RequestOptions::JSON => $body
        ]);

        $responseJson = (string)$response->getBody();

        return $this->createResponse(json_decode($responseJson, true));
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
            'seller_tax_no' => $seller->getTaxIdentificationNumber(),
            'seller_post_code' => $seller->getPostCode(),
            'seller_city' => $seller->getCity(),
            'seller_street' => $seller->getStreet(),
            'seller_country' => $seller->getCountry(),
        ];
    }


    protected function getBuyer()
    {
        $buyer = $this->invoice->getBuyer();

        $buyerAssoc = [
            "buyer_tax_no" => $buyer->hasTaxIdentificationNumber() ? $buyer->getTaxIdentificationNumber() : '',
            "buyer_post_code" => $buyer->getPostCode(),
            "buyer_city" => $buyer->getCity(),
            "buyer_street" => $buyer->getStreet(),
            "buyer_country" => $buyer->getCountry(),
            "buyer_company" => (int)$buyer->hasCompanyName(),
        ];

        if ($buyer->hasCompanyName()) {
            $buyerAssoc['buyer_name'] = $this->getBuyerCompanyNameWithPersonName($buyer);
        } else {
            $buyerAssoc = array_merge($buyerAssoc, $this->getBuyerFirstAndLastName($buyer));
        }

        return $buyerAssoc;
    }


    protected function getBuyerFirstAndLastName(BuyerInterface $buyer)
    {
        $buyerNames = preg_split('/\s/', $buyer->getPersonName());
        return [
            'buyer_first_name' => array_shift($buyerNames),
            'buyer_last_name' => implode(' ', $buyerNames)
        ];
    }


    protected function getBuyerCompanyNameWithPersonName(BuyerInterface $buyer)
    {
        $buyerNames = [
            $buyer->getPersonName()
        ];

        if ($buyer->hasCompanyName()) {
            $buyerNames[] = $buyer->getCompanyName();
        }

        return implode("\n", $buyerNames);
    }


    protected function getBody()
    {
        $body = [
            'invoice' => [
                "kind" => $this->getKind(),
                'number' => $this->invoice->getInvoiceNumber(),
                "issue_date" => $this->invoice->getInvoiceDate()->format("Y-m-d"),
                "place" => $this->invoice->getPlaceOfIssue(),
                "sell_date" => $this->invoice->getTransactionDate()->format("Y-m-d"),
                "positions" => $this->getInvoicePositions(),
                'description' => $this->invoice->getDescription(),
                'payment_to_kind' => 'other_date',
                'payment_to' => $this->invoice->getDueDate()->format("Y-m-d"),
                'disable_tax_no_validation' => true,
            ]
        ];

        if ($this->invoice->hasForeignCurrency()) {
            $body['invoice']["exchange_currency"] = $this->invoice->getForeignCurrency();
        }

        if ($this->invoice->hasExchangeRate()) {
            $body['invoice']['exchange_kind'] = 'own';
            $body['invoice']['exchange_currency_rate'] = $this->invoice->getExchangeRate();
        }

        if ($this->invoice->hasCurrency()) {
            $body['invoice']['currency'] = $this->invoice->getCurrency();
        }

        if ($this->invoice->hasLanguageCode()) {
            $body['invoice']['lang'] = $this->invoice->getLanguageCode();
        }

        $body['invoice'] = array_merge($body['invoice'], $this->getSeller());
        $body['invoice'] = array_merge($body['invoice'], $this->getBuyer());

        return $body;
    }


    protected function getInvoicePositions()
    {
        $return = [];
        foreach ($this->invoice->getPositions() as $position) {
            $return[] = [
                "name" => $position->getName(),
                "tax" => $position->getTaxRatePercent(),
                'total_price_gross' => $position->getGrossTotalPrice(),
                'quantity' => $position->getQuantity(),
            ];
        }

        return $return;
    }


    /**
     * @return Client
     */
    public function getClient(): Client
    {
        if (!$this->client) {
            $this->client = new Client();
        }
        return $this->client;
    }


    /**
     * @param Client $client
     * @return Request
     */
    public function setClient(Client $client): Request
    {
        $this->client = $client;
        return $this;
    }
}
