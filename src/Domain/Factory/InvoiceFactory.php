<?php

namespace L37sg0\Architecture\Domain\Factory;

use DateTime;
use L37sg0\Architecture\Domain\Entity\Invoice;
use L37sg0\Architecture\Domain\Entity\Order;

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