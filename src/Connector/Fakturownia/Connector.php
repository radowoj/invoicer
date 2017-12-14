<?php

declare(strict_types=1);

namespace Radowoj\Invoicer\Connector\Fakturownia;

use Exception;
use Radowoj\Invoicer\AbstractInvoice;
use Radowoj\Invoicer\Connector\AbstractConnector;
use Radowoj\Invoicer\Connector\ConnectorResponseInterface;

class Connector extends AbstractConnector
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
     * @return AbstractRequest
     */
    public function setUsername(string $username): AbstractConnector
    {
        $this->username = $username;
        return $this;
    }


    public function issue(AbstractInvoice $invoice): ConnectorResponseInterface
    {
        $classToMessage = [
            'Radowoj\Invoicer\Invoice\Vat' => 'Radowoj\Invoicer\Connector\Fakturownia\Request\IssueVat',
            'Radowoj\Invoicer\Invoice\Currency' => 'Radowoj\Invoicer\Connector\Fakturownia\Request\IssueCurrency',
            'Radowoj\Invoicer\Invoice\Margin' => 'Radowoj\Invoicer\Connector\Fakturownia\Request\IssueMargin',
        ];

        $invoiceClass = get_class($invoice);

        if (!isset($classToMessage[$invoiceClass])) {
            throw new Exception("Unknown invoice class: {$invoiceClass}");
        }

        $message = new $classToMessage[$invoiceClass]($invoice);
        $message->setToken($this->getToken())
            ->setUsername($this->getUsername());
        return $message->send();
    }

}