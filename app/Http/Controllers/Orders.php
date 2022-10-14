<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use L37sg0\Architecture\Domain\Entity\Order;
use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;
use L37sg0\Architecture\Persistence\Hydrator\OrderHydrator;
use L37sg0\Architecture\Service\InputFilter\OrderInputFilter;

class Orders extends Controller implements IndexInterface
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
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->inputFilter = $inputFilter;
        $this->hydrator = $hydrator;
    }

    public function indexAction()
    {
        $orders = $this->orderRepository->getAll();

        return view('orders.index', compact('orders'));
    }

    public function newAction(Request $request) {
        $viewModel = [];
        $order = new Order();

        if ($request->getMethod() === 'POST') {
            $this->inputFilter->setData($request->request->all());

            if ($this->inputFilter->isValid()) {
                $order = $this->hydrator->hydrate($this->inputFilter->getValues(), $order);

                $this->orderRepository->begin()->persist($order)->commit();

                Session::flash('success', 'Order Saved');

                return new RedirectResponse('/orders/view/' . $order->getId());
            } else {
                $this->hydrator->hydrate($request->request->all(), $order);
                $viewModel['error'] = $this->inputFilter->getMessages();
            }
        }

        $viewModel['customers'] = $this->customerRepository->getAll();
        $viewModel['order'] = $order;

        return view('orders.new', $viewModel);
    }

    public function viewAction($id) {
        $order = $this->orderRepository->getById($id);

        if (!$order) {
            return new Response('', 404);
        }

        return view('orders.view', compact('order'));
    }
}