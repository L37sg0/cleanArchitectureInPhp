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

use L37sg0\Architecture\Domain\Entity\Customer;
use L37sg0\Architecture\Domain\Entity\Invoice;
use L37sg0\Architecture\Domain\Entity\Order;
use L37sg0\Architecture\Persistence\Hydrator\InvoiceHydrator;
use L37sg0\Architecture\Persistence\Hydrator\OrderHydrator;
use L37sg0\Architecture\Persistence\Zend\DataTable\CustomerTable;
use L37sg0\Architecture\Persistence\Zend\DataTable\InvoiceTable;
use L37sg0\Architecture\Persistence\Zend\DataTable\OrderTable;
use L37sg0\Architecture\Persistence\Zend\TableGateway\TableGatewayFactory;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\AdapterServiceFactory;
use Laminas\Hydrator\ClassMethodsHydrator;

return [
    'service_manager' => [
        'factories' => [
            Adapter::class          => AdapterServiceFactory::class,
            OrderHydrator::class    => function($sm) {
                return new OrderHydrator(
                    new ClassMethodsHydrator(),
                    $sm->get(CustomerTable::class)
                );
            },
            InvoiceHydrator::class  => function($sm) {
                return new InvoiceHydrator(
                    new ClassMethodsHydrator(),
                    $sm->get(OrderTable::class)
                );
            },
            CustomerTable::class    => function($sm) {
                $factory    = new TableGatewayFactory();
                $hydrator   = new ClassMethodsHydrator();

                return new CustomerTable(
                    $factory->createGateway(
                        $sm->get(Laminas\Db\Adapter\Adapter::class),
                        $hydrator,
                        new Customer(),
                        'customers'
                    ),
                    $hydrator
                );
            },
            InvoiceTable::class     => function($sm) {
                $factory    = new TableGatewayFactory();
                $hydrator   = $sm->get(InvoiceHydrator::class);

                return new InvoiceTable(
                    $factory->createGateway(
                        $sm->get(Adapter::class),
                        $hydrator,
                        new Invoice(),
                        'invoices'
                    ),
                    $hydrator
                );
            },
            OrderTable::class       => function($sm) {
                $factory    = new TableGatewayFactory();
                $hydrator   = $sm->get(OrderHydrator::class);

                return new OrderTable(
                    $factory->createGateway(
                        $sm->get(Adapter::class),
                        $hydrator,
                        new Order(),
                        'orders'
                    ),
                    $hydrator
                );
            },
        ],
    ]
];
