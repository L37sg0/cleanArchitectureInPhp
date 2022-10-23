<?php

namespace Tests\Domain\Service;

use PHPUnit\Framework\TestCase;
use Tests\InputFilter\Domain\Entity\Invoice;
use Tests\InputFilter\Domain\Entity\Order;
use Tests\InputFilter\Domain\Factory\InvoiceFactory;
use Tests\InputFilter\Domain\Repository\OrderRepositoryInterface;
use Tests\InputFilter\Domain\Service\InvoicingService;

class InvoicingServiceTest extends TestCase
{
    public function testCanCreateClass() {
        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $invoiceFactory = new InvoiceFactory();
        $service = new \Tests\InputFilter\Domain\Service\InvoicingService($orderRepository, $invoiceFactory);

        $this->assertInstanceOf(\Tests\InputFilter\Domain\Service\InvoicingService::class, $service);
    }

    public function testCanQueryRepositoryForUnInvoicedOrders() {
        $order1 = new Order();
        $order2 = new Order();
        $invoiceFactory = new InvoiceFactory();

        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $orderRepository->method('getUnInvoicedOrders')->willReturn([$order1, $order2]);
        $service = new \Tests\InputFilter\Domain\Service\InvoicingService($orderRepository, $invoiceFactory);

        foreach ($service->generateInvoices() as $invoice) {
            $this->assertInstanceOf(Invoice::class, $invoice);
        }
    }

    public function testCanReturnInvoiceForEachUnInvoicedOrder() {
        $order1 = new Order();
        $order1->setTotal(400);
        $order2 = new Order();
        $order2->setTotal(500);
        $orders = [$order1, $order2];
        $invoiceFactory = new InvoiceFactory();

        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $orderRepository->method('getUnInvoicedOrders')->willReturn($orders);
        $service = new InvoicingService($orderRepository, $invoiceFactory);

        foreach ($service->generateInvoices() as $key => $invoice) {
            $this->assertInstanceOf(Invoice::class, $invoice);
            $this->assertEquals($orders[$key]->getTotal(), $invoice->getTotal());
        }


    }


}