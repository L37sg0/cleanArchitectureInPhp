<?php

namespace L37sg0\Architecture\Domain\Repository;

use L37sg0\Architecture\Domain\Entity\AbstractEntity;

interface RepositoryInterface
{
    public function getById(int $id);

    public function getAll();

    public function getBy($conditions = [], $order = [], $limit = null, $offset = null);

    public function persist(AbstractEntity $entity);

    public function begin();

    public function commit();
}