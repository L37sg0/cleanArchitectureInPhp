<?php

namespace App\Http\Controllers;

use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;

class Customers extends Controller implements IndexInterface
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    public function indexAction()
    {
        $customers = $this->customerRepository->getAll();
        return view('customers.index', compact('customers'));
    }

    public function newOrEditAction() {

    }
}