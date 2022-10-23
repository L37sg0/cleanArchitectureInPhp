<?php

namespace L37sg0\Architecture\Persistence\Doctrine\Repository;

use Tests\InputFilter\Domain\Entity\Invoice;

class InvoiceRepository extends AbstractDoctrineRepository implements \Tests\InputFilter\Domain\Repository\InvoiceRepositoryInterface
{
    protected string $entityClass = Invoice::class;
}