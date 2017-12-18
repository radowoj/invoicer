<?php

namespace Radowoj\Invoicer\Connector\Fakturownia\Request;


use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Radowoj\Invoicer\Connector\Fakturownia\AbstractRequest;
use Radowoj\Invoicer\Invoice\Margin;




class IssueMargin extends AbstractRequest
{
    protected $endpoint = 'http://__USERNAME__.fakturownia.pl/invoices.json';

    protected $invoice = null;

    public function __construct(Margin $invoice)
    {
        $this->invoice = $invoice;
    }


    protected function getBody()
    {
        $body = [
            'invoice' => [
                "kind" => 'vat_margin',
                'number' => null,
                "issue_date" => $this->invoice->getInvoiceDate()->format("Y-m-d"),
                "place" => $this->invoice->getPlaceOfIssue(),
                "sell_date" => $this->invoice->getTransactionDate()->format("Y-m-d"),
                "positions" => $this->getInvoicePositions(),
                'description' => $this->invoice->getDescription(),
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
        foreach($this->invoice->getPositions() as $position) {
            $return[] = [
                "name" => $position->getName(),
                "tax" => $position->getTaxRatePercent(),
                'total_price_gross' => $position->getGrossTotalPrice(),
                'quantity' => $position->getQuantity(),
            ];
        }

        return $return;
    }

}