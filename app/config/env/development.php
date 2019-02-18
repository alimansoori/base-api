<?php
return new \Phalcon\Config(
    [
        'database' => [
            'adapter' => 'Mysql',
            'host'     => 'localhost',
            'username' => 'cp32533_cms',
            'password' => '12687139071.ali',
            'dbname'   => 'cp32533_cms',
            'charset'  => 'utf8mb4',
            'prefix'   => 'ilya_'
        ],

        'app' => [
            'baseUri'    => '/'.PROJECT_NAME.'/',
            'modelsDir'  => APP_PATH.'Models/',
            'libraryDir' => APP_PATH.'Lib/',
            'pluginsDir' => APP_PATH.'Plugins/',
            'themesDir'  => BASE_PATH.'public/ilya-theme/',
            'cryptSalt'  => 'eEAfR\|_&G\&f\,+v\U]:\jF\jj!!A&\\\+71w1M\\\s9~8_4L!<@oio[N@DyaI\\P_2My|:\\\+.u>/6m,$D'
        ],

        'memcache'  => [
            'host' => 'localhost',
            'port' => 11211,
        ],

        'memcached'  => [
            'host' => 'localhost',
            'port' => 11211,
        ],

        'cache'     => 'file', // memcache, memcached
    ]
);