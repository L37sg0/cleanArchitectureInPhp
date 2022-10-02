<?php

namespace Application\Controller;

use L37sg0\Architecture\Domain\Entity\Order;
use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;
use L37sg0\Architecture\Persistence\Hydrator\OrderHydrator;
use L37sg0\Architecture\Service\InputFilter\OrderInputFilter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class OrdersController extends AbstractActionController
{
    protected OrderRepositoryInterface $orderRepository;
    protected CustomerRepositoryInterface $customerRepository;
    protected OrderInputFilter $inputFilter;
    protected OrderHydrator $hydrator;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CustomerRepositoryInterface $customerRepository,
        OrderInputFilter $inputFilter,
        OrderHydrator $hydrator
    ) {
        $this->orderRepository      = $orderRepository;
        $this->customerRepository   = $customerRepository;
        $this->inputFilter          = $inputFilter;
        $this->hydrator             = $hydrator;
    }

    public function indexAction()
    {
        return [
            'orders' => $this->orderRepository->getAll()
        ];
    }

    public function viewAction() {
        $id = $this->params()->fromRoute('id');
        $order = $this->orderRepository->getById($id);
        if (!$order) {
            $this->getResponse()->setStatusCode(404);
            return null;
        }
        return [
            'order' => $order
        ];
    }

    public function newAction() {
        $viewModel = new ViewModel();
        $order = new Order();

        if ($this->getRequest()->isPost()) {
            $this->inputFilter
                ->setData($this->params()->fromPost());

            if ($this->inputFilter->isValid()) {
                $order = $this->hydrator->hydrate($this->inputFilter->getValues(), $order);
                $this->orderRepository->begin()->persist($order)->commit();
                $this->flashmessenger()->addSuccessMessage('Order Created');
                $this->redirect()->toUrl('/orders/view/' . $order->getId());
            } else {
                $this->hydrator->hydrate($this->params()->fromPost(), $order);
                $viewModel->setVariable('errors', $this->inputFilter->getMessages());
            }
        }

        $viewModel->setVariable('customers', $this->customerRepository->getAll());
        $viewModel->setVariable('order', $order);

        return $viewModel;
    }
}