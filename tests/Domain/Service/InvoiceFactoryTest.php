<?php

namespace Tests\Domain\Service;

use DateTime;
use PHPUnit\Framework\TestCase;
use Tests\InputFilter\Domain\Entity\Invoice;
use Tests\InputFilter\Domain\Entity\Order;
use Tests\InputFilter\Domain\Factory\InvoiceFactory;

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