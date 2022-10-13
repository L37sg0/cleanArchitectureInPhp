<?php

namespace L37sg0\Architecture\Service\Validator;

use Error;

class StringLength implements ValidatorInterface
{
    protected array $range;
    protected array $messages = [];
    protected const LENGTH_TOO_SHORT = 'The input is less than %d characters long.';
    protected const LENGTH_TOO_LONG = 'The input is more than %d characters long.';

    public function __construct(array $range) {
        if (!array_key_exists('min', $range) || !array_key_exists('max', $range)) {
            throw new Error('Please specify min and max ranges');
        }
        $this->range = $range;
    }

    /**
     * @inheritDoc
     */
    public function isValid($value)
    {
        if (strlen($value) < $this->range['min']) {
            $this->messages['stringLengthTooShort'] = sprintf(self::LENGTH_TOO_SHORT, $this->range['min']);
            return false;
        }
        if (strlen($value) > $this->range['max']) {
            $this->messages['stringLengthTooLong'] = sprintf(self::LENGTH_TOO_LONG, $this->range['max']);

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