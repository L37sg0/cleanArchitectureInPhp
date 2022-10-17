<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use L37sg0\Architecture\Domain\Repository\InvoiceRepositoryInterface;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;
use L37sg0\Architecture\Domain\Service\InvoicingService;

class Invoices extends Controller implements IndexInterface
{
    protected InvoiceRepositoryInterface $invoiceRepository;
    protected OrderRepositoryInterface $orderRepository;
    protected InvoicingService $invoicingService;


    public function __construct(
        InvoiceRepositoryInterface $invoiceRepository,
        OrderRepositoryInterface $orderRepository,
        InvoicingService $invoicingService
    ) {
        $this->invoiceRepository = $invoiceRepository;
        $this->orderRepository = $orderRepository;
        $this->invoicingService = $invoicingService;
    }

    public function indexAction()
    {
        $invoices = $this->invoiceRepository->getAll();

        return view('invoices.index', compact('invoices'));
    }

    public function viewAction($id) {
        $invoice = $this->invoiceRepository->getById($id);

        if (!$invoice) {
            return new Response('', 404);
        }
        $order = $invoice->getOrder();
        return view('invoices.view',compact('invoice', 'order'));
    }

    public function newAction() {
        $orders = $this->orderRepository->getUnInvoicedOrders();
        return view('invoices.new', compact('orders'));
    }

    public function generateAction() {
        $invoices = $this->invoicingService->generateInvoices();

        $this->invoiceRepository->begin();

        foreach ($invoices as $invoice) {
            $this->invoiceRepository->persist($invoice);
        }

        $this->invoiceRepository->commit();

        return view('invoices.generate', compact($invoices));
    }
}