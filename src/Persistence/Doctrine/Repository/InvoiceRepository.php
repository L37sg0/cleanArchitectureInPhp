<?php

namespace L37sg0\Architecture\Persistence\Doctrine\Repository;

use L37sg0\Architecture\Domain\Entity\Invoice;
use L37sg0\Architecture\Domain\Repository\InvoiceRepositoryInterface;

class InvoiceRepository extends AbstractDoctrineRepository implements InvoiceRepositoryInterface
{
    protected string $entityClass = Invoice::class;
}