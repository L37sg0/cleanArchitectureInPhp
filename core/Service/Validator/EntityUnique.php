<?php

namespace L37sg0\Architecture\Service\Validator;

use Tests\InputFilter\Domain\Repository\RepositoryInterface;

class EntityUnique implements ValidatorInterface
{

    protected string $field;
    protected RepositoryInterface $repository;
    protected string $name;
    protected $messages = [];
    protected const ENTITY_ALREADY_EXIST = '%s with such %s already exist.';

    public function __construct(string $field, RepositoryInterface $repository, $name = '')
    {
        $this->field = $field;
        $this->repository = $repository;
        $this->name = $name;
        return $this;
    }
    /**
     * @inheritDoc
     */
    public function isValid($value)
    {
        $conditions = [
            $this->field => $value
        ];
        if ($this->repository->getBy($conditions)) {
            $this->messages['entityNotUnique'] = sprintf(
                self::ENTITY_ALREADY_EXIST,
                !empty($this->name) ? ucfirst(strtolower($this->name)) : 'Entity',
                $this->field
            );
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