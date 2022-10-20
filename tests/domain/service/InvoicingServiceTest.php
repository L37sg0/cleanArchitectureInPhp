<?php

namespace Tests\domain\service;

use L37sg0\Architecture\Domain\Entity\Invoice;
use L37sg0\Architecture\Domain\Entity\Order;
use L37sg0\Architecture\Domain\Factory\InvoiceFactory;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;
use L37sg0\Architecture\Domain\Service\InvoicingService;
use PHPUnit\Framework\TestCase;

class InvoicingServiceTest extends TestCase
{
    public function testCanCreateClass() {
        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $invoiceFactory = new InvoiceFactory();
        $service = new InvoicingService($orderRepository, $invoiceFactory);

        $this->assertInstanceOf(InvoicingService::class, $service);
    }

    public function testCanQueryRepositoryForUnInvoicedOrders() {
        $order1 = new Order();
        $order2 = new Order();
        $invoiceFactory = new InvoiceFactory();

        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $orderRepository->method('getUnInvoicedOrders')->willReturn([$order1, $order2]);
        $service = new InvoicingService($orderRepository, $invoiceFactory);

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