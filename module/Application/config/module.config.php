<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\CustomersController;
use Application\Controller\IndexController;
use Application\Controller\InvoicesController;
use Application\Controller\OrdersController;
use Application\View\Helper\ValidationErrors;
use L37sg0\Architecture\Domain\Factory\InvoiceFactory;
use L37sg0\Architecture\Domain\Service\InvoicingService;
use L37sg0\Architecture\Persistence\Hydrator\OrderHydrator;
use L37sg0\Architecture\Persistence\Zend\DataTable\CustomerTable;
use L37sg0\Architecture\Persistence\Zend\DataTable\InvoiceTable;
use L37sg0\Architecture\Persistence\Zend\DataTable\OrderTable;
use L37sg0\Architecture\Service\InputFilter\CustomerInputFilter;
use L37sg0\Architecture\Service\InputFilter\OrderInputFilter;
use Zend\Hydrator\ClassMethods;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home'          => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application'   => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'customers'     => [
                'type'      => 'Segment',
                'options'   => [
                    'route' => '/customers',
                    'defaults' => [
                        'controller' => CustomersController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'new'   => [
                        'type'      => 'Segment',
                        'options'   => [
                            'route'     => '/new',
                            'defaults'  => [
                                'action'    => 'new-or-edit',
                            ],
                        ],
                    ],
                    'edit'  => [
                        'type'      => 'Segment',
                        'options'   => [
                            'route'         => '/edit/:id',
                            'constraints'   => [
                                'id'    => '[0-9]+',
                            ],
                            'defaults'      => [
                                'action'    => 'new-or-edit',
                            ],
                        ],
                    ],
                ],
            ],
            'orders' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/orders[/:action[/:id]]',
                    'defaults' => [
                        'controller' => OrdersController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'invoices' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/invoices[/:action[/:id]]',
                    'defaults' => [
                        'controller' => InvoicesController::class,
                        'action' => 'index',
                    ],
                ],
            ]
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Application\Controller\Index' => IndexController::class,
        ],
        'factories' => [
            Controller\IndexController::class   => InvokableFactory::class,
            CustomersController::class  => function($services) {
                return new CustomersController(
                    $services->get(CustomerTable::class),
                    new CustomerInputFilter(),
                    new ClassMethods()
                );
            },
            OrdersController::class     => function($services) {
                return new OrdersController(
                    $services->get(OrderTable::class),
                    $services->get(CustomerTable::class),
                    new OrderInputFilter(),
                    $services->get(OrderHydrator::class)
                );
            },
            InvoicesController::class   => function($services) {
                return new InvoicesController(
                    $services->get(InvoiceTable::class),
                    $services->get(OrderTable::class),
                    new InvoicingService(
                        $services->get(OrderTable::class),
                        new InvoiceFactory()
                    )
                );
            },
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'validationErrors' => ValidationErrors::class,
        ]
    ],
    'controller_plugins' => [
        'factories' => [
            FlashMessenger::class => InvokableFactory::class,
        ],
        'aliases' => [
            'flashmessenger' => FlashMessenger::class,
        ]
    ],
];
