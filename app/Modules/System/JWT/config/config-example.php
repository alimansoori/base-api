<?php
return new \Phalcon\Config([
    'database' => [
        'adapter' => 'Mysql',
        'host'    => 'localhost',
        'username' => 'username',
        'password' => 'password',
        'dbname' => 'dbname',
        'charset' => 'utf8mb4',
        'prefix' => 'ilya_',
        'dialectClass' => \Phalcon\Db\Dialect\MysqlExtended::class
    ]
]);