<?php

namespace L37sg0\Architecture\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use RuntimeException;

class RepositoryFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        if (class_exists($requestedName, true)) {
            return new $requestedName(
                $container->get(EntityManager::class)
            );
        }
        throw new RuntimeException('Unknown Repository requested: ' . $requestedName);
    }
}