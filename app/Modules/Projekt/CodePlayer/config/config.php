<?php
return new \Phalcon\Config([
    'database' => [
        'adapter' => 'Mysql',
        'host'    => 'localhost',
        'username' => 'cp32533_projekt',
        'password' => '12687139071.ali',
        'dbname' => 'cp32533_projekt',
        'charset' => 'utf8mb4',
        'prefix' => 'ilya_',
        'dialectClass' => \Phalcon\Db\Dialect\MysqlExtended::class
    ]
]);