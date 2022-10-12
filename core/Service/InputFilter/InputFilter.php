<?php

namespace L37sg0\Architecture\Service\InputFilter;

class InputFilter implements InputInterface
{
    protected array $fields = [];

    protected array $messages = [];

    protected array $data = [];

    public function add(InputInterface $field, ?string $fieldName = null) {
        if ($fieldName) {
            $this->fields[$fieldName] = $field;
        } else {
            $this->fields[] = $field;
        }
        return $this;
    }

    public function getFields() {
        return $this->fields;
    }

    public function setData(array $data) {
        $this->data = $data;
        return $this;
    }

    public function isValid($value = null) {

        return true;
    }

    public function getMessages() {
        return $this->messages;
    }
}