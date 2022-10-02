<?php

namespace L37sg0\Architecture\Persistence\Doctrine\Repository;

use L37sg0\Architecture\Domain\Entity\Customer;
use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;

class CustomerRepository extends AbstractDoctrineRepository implements CustomerRepositoryInterface
{
    protected $entityClass = Customer::class;
}