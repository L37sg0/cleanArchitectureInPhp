<?php

namespace Application\Controller;

use L37sg0\Architecture\Domain\Repository\InvoiceRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;

class InvoicesController extends AbstractActionController
{
    protected InvoiceRepositoryInterface $invoiceRepository;

    public function __construct(
        InvoiceRepositoryInterface $invoiceRepository
    ) {
        $this->invoiceRepository    = $invoiceRepository;
    }

    public function indexAction() {
        $invoices = $this->invoiceRepository->getAll();

        return [
            'invoices' => $invoices
        ];
    }
}