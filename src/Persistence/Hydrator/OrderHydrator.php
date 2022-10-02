<?php

namespace L37sg0\Architecture\Persistence\Hydrator;

use L37sg0\Architecture\Domain\Entity\Customer;
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
        $customer = null;

        if (isset($data['customer'])) {
            $customer = $this->wrappedHydrator->hydrate($data['customer'], new Customer());
            unset($data['customer']);
        }

        if (isset($data['customer_id'])) {
            $customer = $this->customerRepository->getById($data['customer_id']);
        }

        $this->wrappedHydrator->hydrate($data, $order);

        if ($customer) {
            $order->setCustomer($customer);
        }

        return $order;
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