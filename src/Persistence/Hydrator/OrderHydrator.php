<?php

namespace L37sg0\Architecture\Persistence\Hydrator;

use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;
use Laminas\Hydrator\HydratorInterface;

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
        if (isset($data['customer']) && isset($data['customer']['id'])) {
            $data['customer'] = $this->customerRepository->getById($data['customer']['id']);
        }

        return $this->wrappedHydrator->hydrate($data, $order);
    }

    public function extract($object): array
    {
        $data = $this->wrappedHydrator->extract($object);

        if (array_key_exists('customer', $data) && !empty($data['customer'])) {
            $data['customer_id'] = $data['customer']->getId();
            unset($data['customer']);
        }

        return $data;
    }
}