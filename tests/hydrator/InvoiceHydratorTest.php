<?php

namespace Tests\hydrator;

use DateTime;
use L37sg0\Architecture\Domain\Entity\Invoice;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;
use L37sg0\Architecture\Persistence\Hydrator\ClassMethodsHydrator;
use L37sg0\Architecture\Persistence\Hydrator\InvoiceHydrator;
use PHPUnit\Framework\TestCase;

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
        var_dump($invoice,$data);exit();

        $this->assertEquals($invoice->getInvoiceDate()->format('Y-m-d'), $data['invoice_date']);
    }
}