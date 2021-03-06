<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Connector\Fakturownia;

use Exception;
use GuzzleHttp\Client;
use Radowoj\Invoicer\AbstractInvoice;
use Radowoj\Invoicer\Connector\IssueResponseInterface;
use Radowoj\Invoicer\Connector\ConnectorResponseInterface;
use Radowoj\Invoicer\Connector\Connector as AbstractConnector;
use Radowoj\Invoicer\Connector\Fakturownia\Request\DeleteInvoice;

class Connector extends AbstractConnector
{

    /**
     * @var Client
     */
    protected $client;

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
        if ($this->token === '') {
            throw new Exception('Token has not been set');
        }
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token)
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
    public function setUsername(string $username): Connector
    {
        $this->username = $username;
        return $this;
    }


    public function issue(AbstractInvoice $invoice): IssueResponseInterface
    {
        $classToRequest = [
            'Radowoj\Invoicer\Invoice\Vat' => 'Radowoj\Invoicer\Connector\Fakturownia\Request\IssueVat',
            'Radowoj\Invoicer\Invoice\Margin' => 'Radowoj\Invoicer\Connector\Fakturownia\Request\IssueMargin',
        ];

        $invoiceClass = get_class($invoice);

        if (!isset($classToRequest[$invoiceClass])) {
            throw new Exception("Unknown invoice class: {$invoiceClass}");
        }

        $request = new $classToRequest[$invoiceClass]($invoice);
        $request->setToken($this->getToken())
            ->setUsername($this->getUsername())
            ->setClient($this->getClient());

        return $request->send();
    }

    public function delete(int $idInvoice): ConnectorResponseInterface
    {
        $request = new DeleteInvoice($this->getToken(), $this->getUsername(), $this->getClient());

        return $request->send($idInvoice);
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
     * @return Connector
     */
    public function setClient(Client $client): Connector
    {
        $this->client = $client;
        return $this;
    }
}
