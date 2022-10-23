<?php

namespace Tests\InputFilter\Domain\Factory;

use DateTime;
use Tests\InputFilter\Domain\Entity\Invoice;
use Tests\InputFilter\Domain\Entity\Order;

class InvoiceFactory
{
    public function createFromOrder(Order $order): Invoice {
        $invoice = new Invoice();
        $invoice->setOrder($order);
        $invoice->setInvoiceDate(new DateTime());
        $invoice->setTotal($order->getTotal());

        return $invoice;
    }
}