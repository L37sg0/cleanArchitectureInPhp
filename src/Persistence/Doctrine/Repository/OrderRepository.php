<?php

namespace L37sg0\Architecture\Persistence\Doctrine\Repository;

use Doctrine\ORM\Query\Expr\Join;
use L37sg0\Architecture\Domain\Entity\Invoice;
use L37sg0\Architecture\Domain\Entity\Order;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;

class OrderRepository extends AbstractDoctrineRepository implements OrderRepositoryInterface
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