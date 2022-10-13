<?php

namespace L37sg0\Architecture\Service\Validator;

class IsFloat implements ValidatorInterface
{
    protected $messages = [];
    protected const FLOAT_NOT_VALID = 'The input does not appear to be a float.';

    /**
     * @inheritDoc
     */
    public function isValid($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
            $this->messages['notFloat'] = self::FLOAT_NOT_VALID;
            return false;
        }
        
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getMessages()
    {
        return $this->messages;
    }
}