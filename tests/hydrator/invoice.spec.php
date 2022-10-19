<?php

use L37sg0\Architecture\Domain\Entity\Invoice;
use L37sg0\Architecture\Domain\Entity\Order;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;
use L37sg0\Architecture\Persistence\Hydrator\InvoiceHydrator;
use Laminas\Hydrator\ClassMethodsHydrator;

describe(InvoiceHydrator::class, function () {
    beforeEach(function () {
        $this->repository = $this->getProphet()
            ->prophesize(OrderRepositoryInterface::class);

        $this->hydrator = new InvoiceHydrator(new ClassMethodsHydrator(), $this->repository->reveal());
    });
    describe('->extract()', function () {
        it('1. Should perform simple extraction on the object.', function () {
            $invoice = new Invoice();
            $invoice->setTotal(300.14);

            $data = $this->hydrator->extract($invoice);

            assert($data['total'] === $invoice->getTotal(), 'total not equal');
        });

        it('2. Should extract a DateTime object to a string.', function () {
            $invoiceDate    = new DateTime();
            $invoice        = new Invoice();
            $invoice->setInvoiceDate($invoiceDate);

            $data = $this->hydrator->extract($invoice);

            assert($data['invoice_date'] === $invoice->getInvoiceDate()->format('Y-m-d'));
        });

        it('3. Should extract the order object.', function () {
            $invoice = new Invoice();
            $invoice->setOrder((new Order())->setId(14));

            $data = $this->hydrator->extract($invoice);

            assert($data['order_id'] === $invoice->getOrder()->getId());
        });
    });

    describe('->hydrate()', function () {
        it('4. Should perform simple hydration on the object.', function () {
            $data = ['total' => 300.14];
            $invoice = $this->hydrator->hydrate($data, new Invoice());

            assert($invoice->getTotal() === $data['total']);
        });

        it('5. Should hydrate a DateTime object.', function () {
            $data = ['invoice_date' => '2022-10-01'];
            $invoice = $this->hydrator->hydrate($data, new Invoice());

            assert($invoice->getInvoiceDate()->format('Y-m-d') === $data['invoice_date']);
        });

        it('6. Should hydrate an Order entity on the Invoice.', function () {
            $data = ['order_id' => 500];

            $order = (new Order())->setId(500);
            $invoice = new Invoice();

            $this->repository->getById(500)
                ->shouldBeCalled()
                ->willReturn($order);

            $this->hydrator->hydrate($data, $invoice);

            assert($invoice->getOrder() === $order);

            $this->getProphet()->checkPredictions();
        });

        it('7. Should hydrate the embedded order data.', function () {
            $data = ['order' => ['id' => 20]];
            $invoice = new Invoice();

            $this->hydrator->hydrate($data, $invoice);

            assert($invoice->getOrder()->getId() === $data['order']['id']);
        });
    });
});