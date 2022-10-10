<?php

namespace L37sg0\Architecture\Persistence\Hydrator\Strategy;

use DateTime;

class DateStrategy implements StrategyInterface
{
    public function extract($value, ?object $object = null)
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d');
        }

        return $value;
    }


    public function hydrate($value, ?array $data = null) {
        if (is_string($value)) {
            $value = new DateTime($value);
        }

        return $value;
    }
}