<?php

return [
    'doctrine' => [
        'driver' => [
            'orm_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\YamlDriver',
                'cache' => 'array',
                'paths' => [
                    realpath(__DIR__ . '/../../src/Domain/Entity'),
                    realpath(__DIR__ . '/../../src/Persistence/Doctrine/Mapping')
                ],
            ],
            'orm_default' => [
                'drivers' => ['L37sg0\Architecture\Domain\Entity' => 'orm_driver']
            ]
        ],
    ],
];