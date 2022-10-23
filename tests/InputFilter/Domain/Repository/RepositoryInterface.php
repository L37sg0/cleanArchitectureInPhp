<?php

namespace Tests\InputFilter\Domain\Repository;

use Tests\InputFilter\Domain\Entity\AbstractEntity;

interface RepositoryInterface
{
    public function getById(int $id);

    public function getAll();

    public function getBy($conditions = [], $order = [], $limit = null, $offset = null);

    public function persist(AbstractEntity $entity);

    public function begin();

    public function commit();
}