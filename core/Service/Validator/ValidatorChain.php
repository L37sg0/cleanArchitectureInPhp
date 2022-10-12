<?php

namespace L37sg0\Architecture\Service\Validator;

use Countable;

class ValidatorChain implements Countable, ValidatorInterface
{
    protected array $validators = [];

    protected array $messages = [];

    public function isValid($value)
    {
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($value)) {
                $this->messages[] = $validator->getMessages();
                return false;
            }
        }
        return true;
    }
    public function count()
    {
        return count($this->validators);
    }
    public function getMessages()
    {
        return $this->messages;
    }

    public function attach(ValidatorInterface $validator) {
        $this->validators[] = $validator;
        return $this;
    }
}