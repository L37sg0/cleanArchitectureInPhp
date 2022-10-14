<?php

namespace L37sg0\Architecture\Service\Validator;

class EmailAddress implements ValidatorInterface
{
    protected $messages = [];

    protected const EMAIL_NOT_VALID = '%s is not a valid email address.';

    public function isValid($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->messages['emailNotValid'] = sprintf(self::EMAIL_NOT_VALID, $value);
            return false;
        }
        return true;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}