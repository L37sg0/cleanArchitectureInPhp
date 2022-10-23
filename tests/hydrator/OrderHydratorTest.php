<?php

namespace Tests\hydrator;

use L37sg0\Architecture\Domain\Entity\Customer;
use L37sg0\Architecture\Domain\Entity\Order;
use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;
use L37sg0\Architecture\Persistence\Hydrator\ClassMethodsHydrator;
use L37sg0\Architecture\Persistence\Hydrator\OrderHydrator;
use PHPUnit\Framework\TestCase;

class OrderHydratorTest extends TestCase
{
    public function testCanPerformBasicHydrationOnAttributes() {
        $customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $hydrator = new OrderHydrator(new ClassMethodsHydrator(), $customerRepository);

        $data = [
            'id' => 100,
            'order_number' => '20150101-019',
            'description' => 'simple order',
            'total' => 5000
        ];
        $order = new Order();
        $hydrator->hydrate($data, $order);

        $this->assertEquals($data['id'], $order->getId());
        $this->assertEquals($data['order_number'], $order->getOrderNumber());
        $this->assertEquals($data['description'], $order->getDescription());
        $this->assertEquals($data['total'], $order->getTotal());
    }

    public function testCanHydrateEmbeddedCustomerData() {
        $customerId = 20;
        $customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $customerRepository->method('getById')->willReturn((new Customer())->setId($customerId))->with($customerId);
        $hydrator = new OrderHydrator(new ClassMethodsHydrator(), $customerRepository);

        $data['customer']['id'] = $customerId;
        $order = new Order();
        $hydrator->hydrate($data, $order);

        $this->assertEquals($data['customer']['id'], $order->getCustomer()->getId());
    }

    public function testCanExtractCustomerObject() {

        $customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $hydrator = new OrderHydrator(new ClassMethodsHydrator(), $customerRepository);

        $order = new Order();
        $order->setCustomer((new Customer())->setId(20));
        $data = $hydrator->extract($order);

        $this->assertEquals($data['customer_id'], $order->getCustomer()->getId());
    }
}