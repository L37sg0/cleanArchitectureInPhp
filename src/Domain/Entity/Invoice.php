<?php

namespace L37sg0\Architecture\Domain\Entity;

use DateTime;

class Invoice extends AbstractEntity
{
    protected $order;
    protected $invoiceDate;
    protected $total;

    public function getOrder() {
        return $this->order;
    }

    public function setOrder($order) {
        $this->order = $order;
        return $this;
    }

    public function getInvoiceDate(): DateTime {
        return $this->invoiceDate;
    }

    public function setInvoiceDate(DateTime $invoiceDate): Invoice {
        $this->invoiceDate = $invoiceDate;
        return $this;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
        return $this;
    }
}