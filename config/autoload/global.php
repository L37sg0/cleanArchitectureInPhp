<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use L37sg0\Architecture\Persistence\Doctrine\Repository\CustomerRepository;
use L37sg0\Architecture\Persistence\Doctrine\Repository\InvoiceRepository;
use L37sg0\Architecture\Persistence\Doctrine\Repository\OrderRepository;
use L37sg0\Architecture\Persistence\Doctrine\Repository\RepositoryFactory;
use L37sg0\Architecture\Persistence\Hydrator\OrderHydrator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterServiceFactory;
use Zend\Hydrator\ClassMethods;

return [
    'service_manager' => [
        'factories' => [
            Adapter::class          => AdapterServiceFactory::class,
            OrderHydrator::class => function ($sm) {
                return new OrderHydrator(
                    new ClassMethods(),
                    $sm->get(CustomerRepository::class)
                );
            },
            CustomerRepository::class   => RepositoryFactory::class,
            InvoiceRepository::class    => RepositoryFactory::class,
            OrderRepository::class      => RepositoryFactory::class,
        ],
    ]
];