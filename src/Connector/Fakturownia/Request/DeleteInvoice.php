<?php

namespace Radowoj\Invoicer\Connector\Fakturownia\Request;

use GuzzleHttp\Client;
use Radowoj\Invoicer\Connector\Fakturownia\Response;
use Radowoj\Invoicer\Connector\ConnectorRequestInterface;
use Radowoj\Invoicer\Connector\ConnectorResponseInterface;
use Radowoj\Invoicer\Connector\Fakturownia\Response\DeleteResponse;

class DeleteInvoice implements ConnectorRequestInterface
{
    protected $endpoint = 'https://__USERNAME__.fakturownia.pl/invoices/__ID__.json?api_token=__API_TOKEN__';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $username;

    public function __construct(string $token, string $username, Client $client = null)
    {
        $this->token = $token;
        $this->username = $username;
        $this->client = $client ?: new Client();
    }

    public function send(int $idInvoice): ConnectorResponseInterface
    {
        return $this->sendRequest($this->getEndpoint($idInvoice));
    }

    private function sendRequest(string $endpoint): ConnectorResponseInterface
    {
        $response = $this->client->delete($endpoint);

        return $this->createResponse(json_decode((string) $response->getBody(), true));
    }

    protected function createResponse(string $response): ConnectorResponseInterface
    {
        return new DeleteResponse([
            'code' => '',
            'message' => $response
        ]);
    }

    private function getEndpoint(int $idInvoice)
    {
        return str_replace(
            ['__USERNAME__', '__ID__', '__API_TOKEN__'],
            [$this->username, $idInvoice, $this->token],
            $this->endpoint
        );
    }
}
