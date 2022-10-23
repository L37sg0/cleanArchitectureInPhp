<?php

namespace L37sg0\Architecture\Service\InputFilter;

use L37sg0\Architecture\Service\Validator\EmailAddress;
use L37sg0\Architecture\Service\Validator\EntityUnique;
use Tests\InputFilter\Domain\Repository\CustomerRepositoryInterface;

class CustomerInputFilter extends InputFilter
{
    public function __construct(CustomerRepositoryInterface $repository) {
        $name = (new Input('name'))->setRequired(true);
        $email = (new Input('email'))->setRequired(true);
        $email->getValidatorChain()->attach(new EmailAddress())
            ->attach(new EntityUnique('email', $repository, 'Customer'));
        $this->add($name);
        $this->add($email);
    }
}