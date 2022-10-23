<?php

namespace L37sg0\Architecture\Persistence\Doctrine\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Tests\InputFilter\Domain\Entity\Invoice;
use Tests\InputFilter\Domain\Entity\Order;

class OrderRepository extends AbstractDoctrineRepository implements \Tests\InputFilter\Domain\Repository\OrderRepositoryInterface
{
    protected string $entityClass = Order::class;

    public function getUnInvoicedOrders()
    {
        $builder = $this->entityManager->createQueryBuilder()
            ->select('o')
            ->from($this->entityClass, 'o')
            ->leftJoin(Invoice::class, 'i', Join::WITH, 'i.order = o')
            ->where('i.id IS NULL');

        return $builder->getQuery()->getResult();
    }
}