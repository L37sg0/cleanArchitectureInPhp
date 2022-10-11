<?php

namespace L37sg0\Architecture\Service\InputFilter;


use L37sg0\Architecture\Service\Validator\ValidatorChain;

class Input implements InputInterface
{
    protected string $name;

    protected bool $required = false;

    protected ValidatorChain $validatorChain;

    protected array $messages = [];

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function setRequired(bool $required) {
        $this->required = $required;
        return $this;
    }

    public function getRequired() {
        return $this->required;
    }

    public function setValidatorChain(ValidatorChain $validatorChain) {
        $this->validatorChain = $validatorChain;
    }

    public function getValidatorChain() {
        if (!isset($this->validatorChain)) {
            $this->validatorChain = new ValidatorChain();
        }
        return $this->validatorChain;
    }

    public function isValid($value)
    {
        // TODO: Implement isValid() method.
    }

    public function getMessages()
    {
        // TODO: Implement getMessages() method.
    }
}
