<?php

namespace L37sg0\Architecture\Persistence\Doctrine\Repository;

use L37sg0\Architecture\Domain\Entity\AbstractEntity;
use L37sg0\Architecture\Domain\Repository\RepositoryInterface;
use Doctrine\ORM\EntityManager;
use RuntimeException;

class AbstractDoctrineRepository implements RepositoryInterface
{
    protected EntityManager $entityManager;
    protected $entityClass;

    public function __construct(
        EntityManager $entityManager
    ) {
        if (empty($this->entityClass)) {
            throw new RuntimeException(
                get_class($this) . '::$entityClass is not defined'
            );
        }
        $this->entityManager = $entityManager;
    }

    public function getById($id) {
        return $this->entityManager->find($this->entityClass, $id);
    }

    public function getAll() {
        return $this->entityManager->getRepository($this->entityClass)->findAll();
    }

    public function getBy(
        $conditions = [],
        $order = [],
        $limit = null,
        $offset = null
    ) {
        $repository = $this->entityManager->getRepository($this->entityClass);
        $results = $repository->findBy(
            $conditions,
            $order,
            $limit,
            $offset
        );

        return $results;
    }

    public function persist(AbstractEntity $entity)
    {
        $this->entityManager->persist($entity);
        return $this;
    }

    public function begin()
    {
        $this->entityManager->beginTransaction();
        return $this;
    }

    public function commit()
    {
        $this->entityManager->flush();
        $this->entityManager->commit();
        return $this;
    }
}