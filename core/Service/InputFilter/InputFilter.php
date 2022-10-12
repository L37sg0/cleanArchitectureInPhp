<?php

namespace L37sg0\Architecture\Service\InputFilter;

class InputFilter implements InputFilterInterface
{
    protected array $fields = [];

    protected array $messages = [];

    protected array $data = [];

//    public function add(InputInterface $field, ?string $fieldName = null) {
//        if ($fieldName) {
//            $this->fields[$fieldName][$field->getName()] = $field;
//        } else {
//            $this->fields[$field->getName()] = $field;
//        }
//        return $this;
//    }
public function add($input, $name = null)
{
    // TODO: Implement add() method.
}

    public function getFields() {
        return $this->fields;
    }

//    public function setData(array $data) {
//        $this->data = $data;
//        return $this;
//    }
public function setData($data)
{
    // TODO: Implement setData() method.
}

    public function isValid($value = null) {
        foreach ($this->fields as $fieldName => $inputValidator) {
            if (!$inputValidator->isValid($this->data[$fieldName])) {
                $this->messages[$fieldName] = $inputValidator->getMessages();
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
    public function getValues()
    {
        // TODO: Implement getValues() method.
    }
    public function count()
    {
        // TODO: Implement count() method.
    }
    public function getRawValue($name)
    {
        // TODO: Implement getRawValue() method.
    }public function getInvalidInput()
{
    // TODO: Implement getInvalidInput() method.
}public function getValue($name)
{
    // TODO: Implement getValue() method.
}public function setValidationGroup($name)
{
    // TODO: Implement setValidationGroup() method.
}
public function remove($name)
{
    // TODO: Implement remove() method.
}
public function getValidInput()
{
    // TODO: Implement getValidInput() method.
}
public function getRawValues()
{
    // TODO: Implement getRawValues() method.
}
public function get($name)
{
    // TODO: Implement get() method.
}
public function has($name)
{
    // TODO: Implement has() method.
}
}