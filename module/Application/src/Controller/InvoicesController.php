<?php

namespace Application\Controller;

use L37sg0\Architecture\Domain\Repository\InvoiceRepositoryInterface;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;
use L37sg0\Architecture\Domain\Service\InvoicingService;
use Laminas\Mvc\Controller\AbstractActionController;

class InvoicesController extends AbstractActionController
{
    protected InvoiceRepositoryInterface $invoiceRepository;
    protected OrderRepositoryInterface $orderRepository;
    protected InvoicingService $invoicingService;

    public function __construct(
        InvoiceRepositoryInterface $invoiceRepository,
        OrderRepositoryInterface $orderRepository,
        InvoicingService $invoicingService
    ) {
        $this->invoiceRepository    = $invoiceRepository;
        $this->orderRepository      = $orderRepository;
        $this->invoicingService     = $invoicingService;
    }

    public function indexAction() {
        $invoices = $this->invoiceRepository->getAll();

        return [
            'invoices' => $invoices
        ];
    }

    public function generateAction() {
        return [
            'orders' => $this->orderRepository->getUnInvoicedOrders()
        ];
    }

    public function generateProcessAction() {
        $invoices   = $this->invoicingService->generateInvoices();

        $this->invoiceRepository->begin();

        foreach ($invoices as $invoice) {
            $this->invoiceRepository->persist($invoice);
        }

        $this->invoiceRepository->commit();

        return [
            'invoices' => $invoices
        ];
    }

    public function viewAction() {
        $id = $this->params()->fromRoute('id');
        $invoice = $this->invoiceRepository->getById($id);

        if (!$invoice) {
            $this->getResponse()->setStatusCode(404);
            return null;
        }

        return [
            'invoice'   => $invoice,
            'order'     => $invoice->getOrder()
        ];
    }
}