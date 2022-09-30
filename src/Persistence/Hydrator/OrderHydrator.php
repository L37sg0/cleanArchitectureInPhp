<?php

namespace L37sg0\Architecture\Persistence\Hydrator;

use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;
use Zend\Hydrator\HydratorInterface;

class OrderHydrator implements HydratorInterface
{
    protected HydratorInterface $wrappedHydrator;
    protected CustomerRepositoryInterface $customerRepository;

    public function __construct(
        HydratorInterface $wrappedHydrator,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->wrappedHydrator      = $wrappedHydrator;
        $this->customerRepository   = $customerRepository;
    }

    public function hydrate(array $data, $order)
    {
        $this->wrappedHydrator->hydrate($data, $order);

        if (isset($data['customer_id'])) {
            $order->setCustomer(
                $this->customerRepository->getById($data['customer_id'])
            );
        }

        return $order;
    }

    public function extract($object)
    {
        return $this->wrappedHydrator->extract($object);
    }
}