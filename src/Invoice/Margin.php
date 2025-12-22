<?php

namespace Radowoj\Invoicer\Invoice;

use DateTime;
use Radowoj\Invoicer\AbstractInvoice;
use Radowoj\Invoicer\Invoice\Party\BuyerInterface;
use Radowoj\Invoicer\Invoice\Party\SellerInterface;
use Radowoj\Invoicer\Invoice\Positions\Collection;

class Margin extends AbstractInvoice
{
    public const PROCEDURE_VAT_MARGIN_TOURISM = 'procedura marży dla biur podróży';

    public const PROCEDURE_VAT_MARGIN_USED_GOODS = 'procedura marży – towary używane';

    public const PROCEDURE_VAT_MARGIN_ARTWORK = 'procedura marży – dzieła sztuki';

    public const PROCEDURE_VAT_MARGIN_COLLECTIBLES = 'procedura marży – przedmioty kolekcjonerskie i antyki';
    
    public function __construct(
        SellerInterface $seller,
        BuyerInterface $buyer,
        Collection $positions,
        DateTime $invoiceDate = null,
        DateTime $transactionDate = null,
        string $procedureVatMargin,
        string $invoiceNumber = null
    ) {
        if (is_null($invoiceDate)) {
            $invoiceDate = new DateTime('now');
        }

        if (is_null($transactionDate)) {
            $transactionDate = new DateTime('now');
        }

        $this->setSeller($seller);
        $this->setBuyer($buyer);
        $this->setPositions($positions);
        $this->setInvoiceDate($invoiceDate);
        $this->setTransactionDate($transactionDate);
        $this->setProcedureVatMargin($procedureVatMargin);
        $this->setInvoiceNumber($invoiceNumber);
    }
}
