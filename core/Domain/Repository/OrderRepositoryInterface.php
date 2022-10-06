<?php

namespace L37sg0\Architecture\Domain\Repository;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getUnInvoicedOrders();
}