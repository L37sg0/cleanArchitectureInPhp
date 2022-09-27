<?php

namespace L37sg0\Architecture\Domain\Service;

use L37sg0\Architecture\Domain\Factory\InvoiceFactory;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;

class InvoicingService
{
    protected OrderRepositoryInterface $orderRepository;
    protected InvoiceFactory $invoiceFactory;

    public function __construct(OrderRepositoryInterface $orderRepository, InvoiceFactory $invoiceFactory) {
        $this->orderRepository = $orderRepository;
        $this->factory = $invoiceFactory;
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