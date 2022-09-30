<?php

namespace Application\Controller;

use L37sg0\Architecture\Domain\Entity\Customer;
use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;
use L37sg0\Architecture\Service\InputFilter\CustomerInputFilter;
use Zend\Hydrator\HydratorInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CustomersController extends AbstractActionController
{
    protected CustomerRepositoryInterface $customerRepository;
    protected CustomerInputFilter $inputFilter;
    protected HydratorInterface $hydrator;

    public function __construct(
        CustomerRepositoryInterface $customers,
        CustomerInputFilter $inputFilter,
        HydratorInterface $hydrator
    )
    {
        $this->customerRepository   = $customers;
        $this->inputFilter          = $inputFilter;
        $this->hydrator             = $hydrator;
    }

    public function indexAction()
    {
        return [
            'customers' => $this->customerRepository->getAll()
        ];
    }

    public function newOrEditAction() {
        $viewModel = new ViewModel();

        $id = $this->params()->fromRoute('id');
        $customer = $id ? $this->customerRepository->getById($id) : new Customer();

        if ($this->getRequest()->isPost()) {
            $this->inputFilter->setData($this->params()->fromPost());
            if ($this->inputFilter->isValid()) {
                $this->hydrator->hydrate($this->inputFilter->getValues(), $customer);
                $this->customerRepository->begin()->persist($customer)->commit();
                $this->flashmessenger()->addSuccessMessage('Customer Saved');
                $this->redirect()->toUrl('/customers/edit/' . $customer->getId());
            } else {
                $this->hydrator->hydrate($this->params()->fromPost(), $customer);
            }
            $viewModel->setVariable('errors', $this->inputFilter->getMessages());
        }
        $viewModel->setVariable('customer', $customer);

        return $viewModel;
    }
}