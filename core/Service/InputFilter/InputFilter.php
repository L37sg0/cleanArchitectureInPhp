<?php

namespace L37sg0\Architecture\Service\InputFilter;

class InputFilter implements InputFilterInterface
{
    protected array $inputs = [];

    protected array $messages = [];

    protected array $data = [];

    public function add($input, ?string $inputName = null) {
        if ($inputName) {
            $this->inputs[$inputName] = $input;
        } else {
            $this->inputs[$input->getName()] = $input;
        }
        return $this;
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
            if (!$inputValidator->isValid($this->data[$inputName])) {
                $this->messages[$inputName] = $inputValidator->getMessages()[0];
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
}