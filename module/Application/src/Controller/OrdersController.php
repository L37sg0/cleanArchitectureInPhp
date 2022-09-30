<?php

namespace Application\Controller;

use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;
use Zend\Mvc\Controller\AbstractActionController;

class OrdersController extends AbstractActionController
{
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orders
    ) {
        $this->orderRepository = $orders;
    }

    public function indexAction()
    {
        return [
            'orders' => $this->orderRepository->getAll()
        ];
    }
}