<?php

use L37sg0\Architecture\Domain\Entity\Invoice;
use L37sg0\Architecture\Domain\Entity\Order;
use L37sg0\Architecture\Domain\Factory\InvoiceFactory;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;
use L37sg0\Architecture\Domain\Service\InvoicingService;

describe('InvoiceFactory', function () {
    describe('->createFromOrder()', function () {
        it('1. Should return an order object.', function () {
            $order = new Order();
            $factory = new InvoiceFactory();
            $invoice = $factory->createFromOrder($order);

            assert(get_class($invoice) === Invoice::class);
        });

        it('2. Should set the total of the invoice.', function () {
            $order = new Order();
            $order->setTotal(500);

            $factory = new InvoiceFactory();
            $invoice = $factory->createFromOrder($order);

            assert($invoice->getTotal() === 500);
        });

        it('3. Should associate the Order to the invoice.', function () {
            $order = new Order();

            $factory = new InvoiceFactory();
            $invoice = $factory->createFromOrder($order);

            assert($invoice->getOrder() === $order);
        });

        it('4. Should set the date of the invoice.', function () {
            $order = new Order();

            $factory = new InvoiceFactory();
            $invoice = $factory->createFromOrder($order);

            assert(get_class($invoice->getInvoiceDate()) === DateTime::class);
        });
    });
});


describe('InvoicingService', function () {
    describe('->generateInvoices()', function () {
        beforeEach(function () {
            $this->repository = $this->getProphet()->prophesize(OrderRepositoryInterface::class);
            $this->factory = $this->getProphet()->prophesize(InvoiceFactory::class);
        });
        afterEach(function () {
            $this->getProphet()->checkPredictions();
        });

        it('5. Should query the repository for uninvoiced Orders.', function () {
            $this->repository->getUnInvoicedOrders()->shouldBeCalled();
            $service = new InvoicingService($this->repository->reveal(), $this->factory->reveal());
            $service->generateInvoices();
        });

        it('6. Should return an Invoice for each uninvoiced Order.', function () {
            $orders = [(new Order())->setTotal(400)];
            $invoices = [(new Invoice())->setTotal(400)];

            $this->repository->getUnInvoicedOrders()->willReturn($orders);
            $this->factory->createFromOrder($orders[0])->willReturn($invoices);

            $service = new InvoicingService($this->repository->reveal(), $this->factory->reveal());
            $results = $service->generateInvoices();

            assert(is_array($results));
            assert(count($results) === count($orders));
        });
    });
});
