<?php

namespace L37sg0\Architecture\Persistence\Hydrator;

use BadMethodCallException;
use L37sg0\Architecture\Persistence\Hydrator\Strategy\StrategyInterface;

class ClassMethodsHydrator implements HydratorInterface
{
    protected $strategies = [];

    public function hydrate(array $data, $object)
    {
        if (!is_object($object)) {
            throw new BadMethodCallException(sprintf(
                '%s expects the provided $object to be a PHP object)',
                __METHOD__
            ));
        }

        $methods = get_class_methods($object);

        foreach ($methods as $method) {
            if (strpos($method, 'set') === 0) {
                $attribute = lcfirst(substr($method, 3));
                if (array_key_exists($attribute, $data)) {
                    $value = $data[$attribute];
                    /** @var StrategyInterface $strategy */
                    if ($strategy = $this->strategies[$attribute]) {
                        $value = $strategy->hydrate($value);
                    }
                    $object->$method($value);
                }
            }
        }

        return $object;
    }

    public function extract($object)
    {
        if (!is_object($object)) {
            throw new BadMethodCallException(sprintf(
                '%s expects the provided $object to be a PHP object)',
                __METHOD__
            ));
        }

        $methods = get_class_methods($object);

        $data = [];

        foreach ($methods as $method) {
            if (strpos($method, 'get') === 0) {
                $attribute = substr($method, 3);
                $value = $object->$method();
                /** @var StrategyInterface $strategy */
                if ($strategy = $this->strategies[$attribute]) {
                    $value = $strategy->extract($value);
                }
                $data[lcfirst($attribute)]  = $value;
            }
        }

        return $data;
    }

    public function addStrategy($name, StrategyInterface $strategy) {
        $this->strategies[$name] = $strategy;
    }

    public function removeStrategy($name) {
        unset($this->strategies[$name]);
    }
}