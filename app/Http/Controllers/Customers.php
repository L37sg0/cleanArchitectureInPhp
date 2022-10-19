<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use L37sg0\Architecture\Domain\Entity\Customer;
use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;
use L37sg0\Architecture\Persistence\Hydrator\HydratorInterface;
use L37sg0\Architecture\Service\InputFilter\CustomerInputFilter;
use L37sg0\Architecture\Service\InputFilter\InputFilter;

class Customers extends Controller implements IndexInterface
{
    protected CustomerRepositoryInterface $customerRepository;
    protected InputFilter $inputFilter;
    protected HydratorInterface $hydrator;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        CustomerInputFilter $inputFilter,
        HydratorInterface $hydrator
    ) {
        $this->customerRepository = $customerRepository;
        $this->inputFilter = $inputFilter;
        $this->hydrator = $hydrator;
    }

    public function indexAction()
    {
        $customers = $this->customerRepository->getAll();
        return view('customers.index', compact('customers'));
    }

    public function newOrEditAction(Request $request, $id = '') {
        $viewModel = [];

        $customer = $id ? $this->customerRepository->getById($id) : new Customer();

        if ($request->getMethod() == 'POST') {
            $this->inputFilter->setData($request->request->all());

            if ($this->inputFilter->isValid()) {
                $this->hydrator->hydrate($this->inputFilter->getValues(), $customer);
                $this->customerRepository
                    ->begin()
                    ->persist($customer)
                    ->commit();

                Session::flash('success', 'Customer Saved');

                return new RedirectResponse(
                    '/customers/edit/' . $customer->getId()
                );
            } else {
                $this->hydrator->hydrate($request->request->all(), $customer);
                $viewModel['error'] = $this->inputFilter->getMessages();
            }
        }

        $viewModel['customer'] = $customer;

        return view('customers.new-or-edit', $viewModel);
    }
}