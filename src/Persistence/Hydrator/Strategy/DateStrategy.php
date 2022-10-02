<?php

namespace L37sg0\Architecture\Persistence\Hydrator\Strategy;

use DateTime;
use Laminas\Hydrator\Strategy\DefaultStrategy;

class DateStrategy extends DefaultStrategy
{

    /**
     * @inheritDoc
     */
    public function extract($value, ?object $object = null)
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d');
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function hydrate($value, ?array $data = null) {
        if (is_string($value)) {
            $value = new DateTime($value);
        }

        return $value;
    }
}