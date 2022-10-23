<?php

namespace Tests\Persistence\Hydrator;

use DateTime;
use L37sg0\Architecture\Persistence\Hydrator\ClassMethodsHydrator;
use L37sg0\Architecture\Persistence\Hydrator\InvoiceHydrator;
use PHPUnit\Framework\TestCase;
use Tests\InputFilter\Domain\Entity\Invoice;
use Tests\InputFilter\Domain\Entity\Order;
use Tests\InputFilter\Domain\Repository\OrderRepositoryInterface;

class InvoiceHydratorTest extends TestCase
{
    public function testCanExtractObject() {
        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $wrappedHydrator = new ClassMethodsHydrator();
        $hydrator = new InvoiceHydrator($wrappedHydrator, $orderRepository);

        $invoice = new Invoice();
        $invoice->setTotal(300.14);

        $data = $hydrator->extract($invoice);

        $this->assertEquals($invoice->getTotal(), $data['total']);
    }

    public function testCanExtractDateTimeToString() {
        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $wrappedHydrator = new ClassMethodsHydrator();
        $hydrator = new InvoiceHydrator($wrappedHydrator, $orderRepository);

        $invoice = new Invoice();
        $invoice->setInvoiceDate(new DateTime());

        $data = $hydrator->extract($invoice);

        $this->assertEquals($invoice->getInvoiceDate()->format('Y-m-d'), $data['invoice_date']);
    }

    public function testCanExtractOrderObject() {
        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $wrappedHydrator = new ClassMethodsHydrator();
        $hydrator = new InvoiceHydrator($wrappedHydrator, $orderRepository);

        $invoice = new Invoice();
        $invoice->setOrder((new Order())->setId(14));

        $data = $hydrator->extract($invoice);

        $this->assertEquals($invoice->getOrder()->getId(), $data['order_id']);
    }

    public function testCanPerformSimpleHydrationOnObject() {
        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $wrappedHydrator = new ClassMethodsHydrator();
        $hydrator = new InvoiceHydrator($wrappedHydrator, $orderRepository);

        $data['total'] = 300.14;
        $invoice = $hydrator->hydrate($data, new Invoice());

        $this->assertEquals($data['total'], $invoice->getTotal());
    }

    public function testCanHydrateDateTimeObject() {
        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $wrappedHydrator = new ClassMethodsHydrator();
        $hydrator = new InvoiceHydrator($wrappedHydrator, $orderRepository);

        $data['invoice_date'] = '2022-10-23';
        $invoice = $hydrator->hydrate($data, new Invoice());

        $this->assertInstanceOf(DateTime::class, $invoice->getInvoiceDate());
        $this->assertEquals($data['invoice_date'], $invoice->getInvoiceDate()->format('Y-m-d'));
    }

    public function testCanHydrateOrderEntityOnInvoice()  {
        $order = (new Order())->setId(500);
        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $orderRepository->method('getById')->willReturn($order)->with(500);
        $wrappedHydrator = new ClassMethodsHydrator();
        $hydrator = new InvoiceHydrator($wrappedHydrator, $orderRepository);

        $data['order_id'] = 500;
        $invoice = $hydrator->hydrate($data, new Invoice());

        $this->assertEquals($order, $invoice->getOrder());
    }

    public function testCanHydrateEmbeddedOrderData() {
        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $wrappedHydrator = new ClassMethodsHydrator();
        $hydrator = new InvoiceHydrator($wrappedHydrator, $orderRepository);

        $data['order']['id'] = 20;
        $invoice = new Invoice();

        $hydrator->hydrate($data, $invoice);

        $this->assertEquals($data['order']['id'], $invoice->getOrder()->getId());
    }
}