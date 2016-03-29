<?php

/**
 * Include application
 */
require_once '../app.php';

use Katran\Helper;
use Katran\Database\Db;


return [
    'paths' =>[
        'migrations' => __DIR__.'/migrations',
        'seeds' => __DIR__.'/seeds',
    ],
    'environments' => [
        'migration_base_class' => 'MyMagicalMigration',
        'default_migration_table' => '_migrations',
        'default_database' => 'production',
        'production' => [
            'adapter' => 'mysql',
            'host'    => Helper::_cfg('db', 'host'),
            'name'    => Helper::_cfg('db', 'name'),
            'user'    => Helper::_cfg('db', 'user'),
            'pass'    => Helper::_cfg('db', 'pass'),
            'port'    => Helper::_cfg('db', 'port'),
            'charset' => Helper::_cfg('db', 'charset'),
        ]
    ]
];