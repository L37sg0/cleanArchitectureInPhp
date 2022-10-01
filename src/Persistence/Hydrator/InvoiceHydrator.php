<?php

namespace L37sg0\Architecture\Persistence\Hydrator;

use L37sg0\Architecture\Domain\Entity\Order;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;
use L37sg0\Architecture\Persistence\Hydrator\Strategy\DateStrategy;
use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\HydratorInterface;

class InvoiceHydrator implements HydratorInterface
{
    protected ClassMethods $wrappedHydrator;
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(
        ClassMethods $wrappedHydrator,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->wrappedHydrator = $wrappedHydrator;
        $this->wrappedHydrator->addStrategy('invoice_date', new DateStrategy());

        $this->orderRepository = $orderRepository;
    }

    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        $data = $this->wrappedHydrator-> extract($object);

        if (array_key_exists('order', $data) && !empty($data['order'])) {
            $data['order_id'] = $data['order']->getId();
            unset($data['order']);
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $invoice)
    {
        $order = null;

        if (isset($data['order'])) {
            $order = $this->wrappedHydrator->hydrate($data['order'], new Order());
            unset($data['order']);
        }

        if (isset($data['order_id'])) {
            $order = $this->orderRepository->getById($data['order_id']);
        }

        $invoice = $this->wrappedHydrator->hydrate($data, $invoice);

        if ($order) {
            $invoice->setOrder($order);
        }

        return $invoice;
    }
}