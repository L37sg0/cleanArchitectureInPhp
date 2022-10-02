<?php

namespace L37sg0\Architecture\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use RuntimeException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RepositoryFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $class = func_get_arg(2);
        $class = 'L37sg0\Architecture\Persistence\Doctrine\Repository\\' . $class;

        if (class_exists($class, true)) {
            return new $class(
                $serviceLocator->get(EntityManager::class)
            );
        }
        throw new RuntimeException('Unknown Repository requested: ' . $class);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // TODO: Implement __invoke() method.
    }
}
/**
 * interface FactoryInterface extends FactoryInterface \Zend\ServiceManager\FactoryInterface
 * Backwards-compatibility shim for FactoryInterface.
 * Implementations should update to implement only Zend\ServiceManager\Factory\FactoryInterface.
 * If upgrading from v2, take the following steps:
 * rename the method createService() to __invoke(), and:
 * rename the $serviceLocator argument to $container, and change the typehint to Interop\Container\ContainerInterface
 * add the $requestedName as a second argument
 * add the optional array $options = null argument as a final argument
 * create a createService() method as defined in this interface, and have it proxy to __invoke().
 * Once you have tested your code, you can then update your class to only implement Zend\ServiceManager\Factory\FactoryInterface, and remove the createService() method.
 */