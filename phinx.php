<?php
$pdo = new PDO('mysql:host=mysql;charset=utf8mb4', 'academy', 'academy');
$pdo->query("CREATE DATABASE IF NOT EXISTS dailymenu");
$pdo->query("CREATE DATABASE IF NOT EXISTS dailymenu_test");

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
        ],
        'environments' => [
            'default_migration_table' => 'phinxlog',
            'default_database' => 'development',
            'development' => [
                'adapter' => 'mysql',
                'host' => 'mysql',
                'name' => 'dailymenu',
                'user' => 'academy',
                'pass' => 'academy',
                'port' => '3306',
                'charset' => 'utf8',
            ],
            'testing' => [
                'adapter' => 'mysql',
                'host' => 'mysql',
                'name' => 'dailymenu_test',
                'user' => 'academy',
                'pass' => 'academy',
                'port' => '3306',
                'charset' => 'utf8',
            ]
        ],
        'version_order' => 'creation'
    ];