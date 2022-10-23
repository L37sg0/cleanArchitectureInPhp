<?php

namespace L37sg0\Architecture\Persistence\Zend\DataTable;

use Tests\InputFilter\Domain\Repository\OrderRepositoryInterface;

class OrderTable extends AbstractDataTable implements OrderRepositoryInterface
{

    public function getUnInvoicedOrders()
    {
        return $this->gateway->select('id NOT IN(SELECT order_id FROM invoices)');
    }
}