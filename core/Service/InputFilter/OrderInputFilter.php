<?php

namespace L37sg0\Architecture\Service\InputFilter;

use L37sg0\Architecture\Domain\Repository\CustomerRepositoryInterface;
use L37sg0\Architecture\Domain\Repository\OrderRepositoryInterface;
use L37sg0\Architecture\Service\Validator\EntityExist;
use L37sg0\Architecture\Service\Validator\EntityUnique;
use L37sg0\Architecture\Service\Validator\IsFloat;
use L37sg0\Architecture\Service\Validator\StringLength;

class OrderInputFilter extends InputFilter
{
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        OrderRepositoryInterface $orderRepository
    ) {
        $customer = (new InputFilter());
        $id = (new Input('id'))
            ->setRequired(true);
        $id->getValidatorChain()->attach(new EntityExist('id', $customerRepository, 'Customer'));
        $customer->add($id);

        $orderNumber = (new Input('orderNumber'))
            ->setRequired(true);
        $orderNumber->getValidatorChain()->attach(
            new StringLength(['min' => 13, 'max' => 13])
        )->attach(new EntityUnique('orderNumber', $orderRepository, 'Order'));

        $description = (new Input('description'))
            ->setRequired(true);

        $total = (new Input('total'))
            ->setRequired(true);
        $total->getValidatorChain()->attach(
            new IsFloat()
        );

        $this->add($customer, 'customer');
        $this->add($orderNumber);
        $this->add($description);
        $this->add($total);
    }
}