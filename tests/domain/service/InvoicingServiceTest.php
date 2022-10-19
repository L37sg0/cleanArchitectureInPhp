<?php

namespace Tests\domain\service;

use L37sg0\Architecture\Domain\Entity\Invoice;
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
        $invoice = new Invoice();
        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $orderRepository->method('getUnInvoicedOrders')->willReturn([$invoice]);
        $invoiceFactory = new InvoiceFactory();
        $service = new InvoicingService($orderRepository, $invoiceFactory);

        $this->assertEquals([$invoice], $service->generateInvoices());
    }
}