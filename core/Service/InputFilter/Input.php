<?php

namespace L37sg0\Architecture\Service\InputFilter;


use L37sg0\Architecture\Service\Validator\ValidatorChain;

class Input implements InputInterface
{
    protected string $name;

    protected bool $required = false;
    protected const REQUIRED_INPUT_ERROR = 'Value is required and can\'t be empty.';

    protected ValidatorChain $validatorChain;

    protected array $messages = [];

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
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
        return $this;
    }

    public function getValidatorChain() {
        if (!isset($this->validatorChain)) {
            $this->validatorChain = new ValidatorChain();
        }
        return $this->validatorChain;
    }

    public function isValid($value)
    {
        if ($this->required && empty((string)$value)){
            $this->messages['isEmpty'] = self::REQUIRED_INPUT_ERROR;
            return false;
        }
        if (!$this->getValidatorChain()->isValid($value)) {
            $this->messages = $this->validatorChain->getMessages();
            return false;
        }
        return true;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
