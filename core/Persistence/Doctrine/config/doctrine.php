<?php

return [
    // database connection information is managed in Laravel's config/database.php file

    'mappings' => [
        'type' => 'yaml',
        'paths' => [base_path('core') . '/Persistence/Doctrine/Mapping']
    ],
];