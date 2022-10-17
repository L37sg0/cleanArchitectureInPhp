<?php

namespace L37sg0\Architecture\Service\Validator;

use L37sg0\Architecture\Domain\Repository\RepositoryInterface;

/**
 * EntityExist validator will check if Entity Repository could return Entity where $field = inserted $value.
 * Will return false if such Entity could not be returned.
 */
class EntityExist implements ValidatorInterface
{
    protected string $field;
    protected RepositoryInterface $repository;
    protected string $name;
    protected $messages = [];
    protected const ENTITY_NOT_EXIST = '%s with such %s does not exist.';

    public function __construct(string $field, RepositoryInterface $repository, $name = '') {
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
        if (!$this->repository->getBy($conditions)) {
            $this->messages['entityNotValid'] = sprintf(
                self::ENTITY_NOT_EXIST,
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