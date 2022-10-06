<?php

namespace L37sg0\Architecture\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManager;
use L37sg0\Architecture\Domain\Entity\AbstractEntity;
use L37sg0\Architecture\Domain\Repository\RepositoryInterface;
use RuntimeException;

class AbstractDoctrineRepository implements RepositoryInterface
{
    protected EntityManager $entityManager;
    protected string $entityClass;

    public function __construct(EntityManager $entityManager) {
        if (empty($this->entityClass)) {
            throw new RuntimeException(get_class($this) . '::$entityClass is not defined');
        }

        $this->entityManager = $entityManager;
    }

    public function getById(int $id)
    {
        return $this->entityManager->find($this->entityClass, $id);
    }

    public function getAll()
    {
        return $this->entityManager->getRepository($this->entityClass)->findAll();
    }

    public function getBy($conditions = [], $order = [], $limit = null, $offset = null) {
        return $this->entityManager->getRepository($this->entityClass)
            ->findBy($conditions, $order, $limit, $offset);
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