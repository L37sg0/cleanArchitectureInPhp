<?php

namespace App\Http\Controllers;

use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;

class Orders extends Controller implements IndexInterface
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function indexAction()
    {
        $orders = $this->orderRepository->getAll();

        return view('orders.index', compact('orders'));
    }
}