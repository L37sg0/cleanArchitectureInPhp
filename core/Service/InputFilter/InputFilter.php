<?php

namespace L37sg0\Architecture\Service\InputFilter;

class InputFilter implements InputInterface
{
    protected array $fields = [];

    protected array $messages = [];

    public function add(InputInterface $field, ?string $name = null) {
        $this->fields[$name] = $field;
    }

    public function isValid($value)
    {
        foreach ($this->fields as $field) {
            if (!$this->isValid($value)) {
                $this->messages[] = $field->getMessages();
                return $this;
            }
        }
        return $this;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}