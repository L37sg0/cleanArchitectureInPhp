<?php

namespace L37sg0\Architecture\Service\InputFilter;

use L37sg0\Architecture\Service\Validator\IsFloat;
use L37sg0\Architecture\Service\Validator\StringLength;

class OrderInputFilter extends InputFilter
{
    public function __construct() {
        $customer = (new InputFilter());
        $id = (new Input('id'))
            ->setRequired(true);
        $customer->add($id);

        $orderNumber = (new Input('orderNumber'))
            ->setRequired(true);
        $orderNumber->getValidatorChain()->attach(
            new StringLength(['min' => 13, 'max' => 13])
        );

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