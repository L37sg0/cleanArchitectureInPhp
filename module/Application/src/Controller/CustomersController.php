<?php

namespace Application\Controller;

use L37sg0\Architecture\Domain\Entity\Customer;
use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;
use L37sg0\Architecture\Service\InputFilter\CustomerInputFilter;
use Zend\Hydrator\HydratorInterface;
use Zend\Mvc\Controller\AbstractActionController;

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

    public function newAction() {
        if ($this->getRequest()->isPost()) {
            $this->inputFilter->setData($this->params()->fromPost());
            if ($this->inputFilter->isValid()) {
                $customer = $this->hydrator->hydrate($this->inputFilter->getValues(), new Customer());
                $this->customerRepository->begin()->persist($customer)->commit();
                $this->flashmessenger()->addSuccessMessage('Customer Saved');
                $this->redirect()->toUrl('/customers');
            } else {

            }
        }
    }
}