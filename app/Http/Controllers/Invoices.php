<?php

namespace App\Http\Controllers;

use L37sg0\Architecture\Domain\Repository\InvoiceRepositoryInterface;

class Invoices extends Controller implements IndexInterface
{
    private InvoiceRepositoryInterface $invoiceRepository;

    public function __construct(
        InvoiceRepositoryInterface $invoiceRepository
    ) {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function indexAction()
    {
        $invoices = $this->invoiceRepository->getAll();

        return view('invoices.index', compact('invoices'));
    }
}