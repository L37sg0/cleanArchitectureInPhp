<?php

namespace L37sg0\Architecture\Persistence\Hydrator;

use L37sg0\Architecture\Persistence\Hydrator\Strategy\DateStrategy;
use Tests\InputFilter\Domain\Entity\Order;
use Tests\InputFilter\Domain\Repository\OrderRepositoryInterface;

class InvoiceHydrator implements HydratorInterface
{
    protected ClassMethodsHydrator $wrappedHydrator;
    protected OrderRepositoryInterface $orderRepository;

    public function __construct(
        ClassMethodsHydrator$wrappedHydrator,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->wrappedHydrator = $wrappedHydrator;
        $this->wrappedHydrator->addStrategy('invoice_date', new DateStrategy());

        $this->orderRepository = $orderRepository;
    }

    /**
     * @inheritDoc
     */
    public function extract($object): array
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