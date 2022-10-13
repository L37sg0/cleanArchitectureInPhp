<?php

namespace L37sg0\Architecture\Service\InputFilter;

use L37sg0\Architecture\Service\Validator\EmailAddress;

class CustomerInputFilter extends InputFilter
{
    public function __construct() {
        $name = (new Input('name'))->setRequired(true);
        $email = (new Input('email'))->setRequired(true);
        $email->getValidatorChain()->attach(new EmailAddress());
        $this->add($name);
        $this->add($email);
    }
}