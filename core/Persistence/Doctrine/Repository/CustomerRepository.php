<?php

namespace L37sg0\Architecture\Persistence\Doctrine\Repository;

use Tests\InputFilter\Domain\Entity\Customer;
use Tests\InputFilter\Domain\Repository\CustomerRepositoryInterface;

class CustomerRepository extends AbstractDoctrineRepository implements CustomerRepositoryInterface
{
    protected string $entityClass = Customer::class;
}