<?php
namespace MasterData;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'masterunit' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/unit[/:id]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'masteritem' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/item[/:id]',
                    'defaults' => [
                        'controller' => Controller\ItemController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'masterpackage' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/package[/:id]',
                    'defaults' => [
                        'controller' => Controller\PackageController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\ItemController::class => InvokableFactory::class,
            Controller\PackageController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
