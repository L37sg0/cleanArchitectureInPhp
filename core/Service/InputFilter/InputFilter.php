<?php

namespace L37sg0\Architecture\Service\InputFilter;

use Error;

class InputFilter implements InputFilterInterface
{
    protected array $inputs = [];

    protected array $messages = [];

    protected array $data = [];

    public function add($input, ?string $inputName = null) {
        if ($input instanceof InputInterface) {
            $this->inputs[$input->getName()] = $input;
            return $this;
        }
        if ($input instanceof InputFilterInterface) {
            if ($inputName) {
                $this->inputs[$inputName] = $input;
                return $this;
            }
            throw new Error('inputName should be provided for input of type InputFilterInterface.');
        }
        throw new Error('input should be instance of InputInterface or InputFilterInterface.');
    }

    public function getInputs() {
        return $this->inputs;
    }

    public function setData(array $data) {
        $this->data = $data;
        return $this;
    }

    public function isValid($value = null) {
        foreach ($this->inputs as $inputName => $inputValidator) {
            if ($inputValidator instanceof InputFilterInterface) {
                $inputValidator->setData($this->data[$inputName]);
            }
            if (!$inputValidator->isValid($this->data[$inputName])) {
                $this->messages[$inputName] = $inputValidator->getMessages();
            }
        }
        if (!empty($this->messages)) {
            return false;
        }
        $this->messages = array_map(function ($value) {
            return null;
        }, $this->data);
        return true;
    }

    public function getMessages() {
        return $this->messages;
    }

    public function getValues() {
        return $this->data;
    }
}