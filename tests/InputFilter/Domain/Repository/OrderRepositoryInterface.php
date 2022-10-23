<?php

namespace Tests\InputFilter\Domain\Repository;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getUnInvoicedOrders();
}