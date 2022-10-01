<?php

use L37sg0\Architecture\Domain\Entity\Customer;
use L37sg0\Architecture\Domain\Entity\Order;
use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;
use L37sg0\Architecture\Persistence\Hydrator\OrderHydrator;
use Zend\Hydrator\ClassMethods;

describe(OrderHydrator::class, function () {
    beforeEach(function () {
        $this->repository = $this->getProphet()->prophesize(
            CustomerRepositoryInterface::class
        );
        $this->hydrator = new OrderHydrator(
            new ClassMethods(),
            $this->repository->reveal()
        );
    });

    describe('->hydrate()', function () {
        it('1. Should perform basic hydration of attributes.', function () {
            $data = [
                'id'            => 100,
                'order_number'  => '20150101-019',
                'description'   => 'simple order',
                'total'         => 5000
            ];

            $order = new Order();
            $this->hydrator->hydrate($data, $order);

            assert($order->getId()          === 100);
            assert($order->getOrderNumber() === '20150101-019');
            assert($order->getDescription() === 'simple order');
            assert($order->getTotal()       === 5000);
        });

        it('2. Should hydrate a Customer entity on the Order.', function () {
            $data = [
                'customer_id' => 500
            ];

            $customer   = (new Customer())->setId(500);
            $order      = new Order();

            $this->repository->getById(500)
                ->shouldBeCalled()
                ->willReturn($customer);

            $this->hydrator->hydrate($data, $order);

            assert($order->getCustomer() === $customer);

            $this->getProphet()->checkPredictions();
        });

        it('3. Should hydrate the embedded customer data.', function () {
            $data = ['customer' => ['id' => 20]];
            $order = new Order();

            $this->hydrator->hydrate($data, $order);

            assert($data['customer']['id'] === $order->getCustomer()->getId(), 'id does not match');
        });

        it('4. Should extract the customer object.', function () {
            $order = new Order();
            $order->setCustomer((new Customer())->setId(14));

            $data = $this->hydrator->extract($order);

            assert($order->getCustomer()->getId() === $data['customer_id'], 'customer_id is not correct');
        });
    });
});