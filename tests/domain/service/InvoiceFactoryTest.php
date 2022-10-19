<?php

namespace Tests\domain\service;

use DateTime;
use L37sg0\Architecture\Domain\Entity\Invoice;
use L37sg0\Architecture\Domain\Entity\Order;
use L37sg0\Architecture\Domain\Factory\InvoiceFactory;
use PHPUnit\Framework\TestCase;

class InvoiceFactoryTest extends TestCase
{
    public function testCanCreateClass() {
        $factory = new InvoiceFactory();

        $this->assertInstanceOf(InvoiceFactory::class, $factory);
    }
    
    public function testCanCreateFromOrderReturnInvoice() {
        $order = new Order();
        $factory = new InvoiceFactory();
        
        $this->assertInstanceOf(Invoice::class, $factory->createFromOrder($order));
    }

    public function testCreateFromOrderSetsInvoiceTotal() {
        $order = new Order();
        $order->setTotal(500);
        $factory = new InvoiceFactory();

        $this->assertEquals(500, $factory->createFromOrder($order)->getTotal());
    }

    public function testAssociatesOrderToInvoice() {
        $order = new Order();
        $factory = new InvoiceFactory();
        $invoice = $factory->createFromOrder($order);

        $this->assertEquals($order, $invoice->getOrder());
    }

    public function testAssociatesDateOfTheInvoice() {
        $order = new Order();
        $factory = new InvoiceFactory();
        $invoice = $factory->createFromOrder($order);

        $this->assertEquals(DateTime::class, get_class($invoice->getInvoiceDate()));
    }
}