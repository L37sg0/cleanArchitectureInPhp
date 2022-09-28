<?php

namespace L37sg0\Architecture\Persistence\Zend\DataTable;

class OrderTable extends AbstractDataTable implements \L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface
{

    public function getUnInvoicedOrders(): array
    {
        return [];
    }
}