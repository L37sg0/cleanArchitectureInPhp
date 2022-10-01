<?php

namespace L37sg0\Architecture\Persistence\Hydrator\Strategy;

use DateTime;
use Zend\Hydrator\Strategy\DefaultStrategy;

class DateStrategy extends DefaultStrategy
{

    /**
     * @inheritDoc
     */
    public function extract($value)
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d');
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function hydrate($value) {
        if (is_string($value)) {
            $value = new DateTime($value);
        }

        return $value;
    }
}