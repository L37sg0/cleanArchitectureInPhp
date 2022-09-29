<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\CustomersController;
use Application\Controller\IndexController;
use Application\Mvc\Controller\Plugin\CustomFlashMessengerFactory;
use L37sg0\Architecture\Persistence\Zend\DataTable\CustomerTable;
use L37sg0\Architecture\Service\InputFilter\CustomerInputFilter;
use Zend\Hydrator\ClassMethods;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Application\Mvc\Controller\Plugin\CustomFlashMessenger;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'customers' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/customers',
                    'defaults' => [
                        'controller' => 'Application\Controller\Customers',
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'create'    => [
                        'type'  => 'Segment',
                        'options'   => [
                            'route' => '/new',
                            'defaults'  => [
                                'action'    => 'new',
                            ],
                        ],
                    ],
                ],
            ],
            'orders' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/orders',
                    'defaults' => [
                        'controller' => 'Application\Controller\Orders',
                        'action' => 'index',
                    ],
                ],
            ],
            'invoices' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/invoices',
                    'defaults' => [
                        'controller' => 'Application\Controller\Invoices',
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
            'Application\Controller\Customers'  => function($sm) {
                return new CustomersController(
                    $sm->getServiceLocator()->get(CustomerTable::class),
                    new CustomerInputFilter(),
                    new ClassMethods()
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
    'controller_plugins' => [
        'factories' => [
            FlashMessenger::class => InvokableFactory::class,
        ],
        'aliases' => [
            'flashmessenger' => FlashMessenger::class,
        ]
    ],
];
