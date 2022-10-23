<?php

namespace Tests\InputFilter\Domain\Service;

use Tests\InputFilter\Domain\Factory\InvoiceFactory;
use Tests\InputFilter\Domain\Repository\OrderRepositoryInterface;

class InvoicingService
{
    protected OrderRepositoryInterface $orderRepository;
    protected InvoiceFactory $invoiceFactory;

    public function __construct(OrderRepositoryInterface $orderRepository, InvoiceFactory $invoiceFactory) {
        $this->orderRepository = $orderRepository;
        $this->invoiceFactory = $invoiceFactory;
    }

    public function generateInvoices(): array {
        $orders = $this->orderRepository->getUnInvoicedOrders();

        $invoices = [];

        foreach ($orders as $order) {
            $invoices[] = $this->invoiceFactory->createFromOrder($order);
        }

        return $invoices;
    }

}