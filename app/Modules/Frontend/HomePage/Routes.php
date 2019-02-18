<?php
namespace Modules\Frontend\HomePage;


use Lib\Module\RoutesModule;
use Lib\Mvc\Router;

class Routes extends RoutesModule
{
    public function init()
    {
        $this->router->add(
            '/{slug:[آ-یa-z0-9\-\_\/]*}',
            [
                'module'     => $this->moduleName,
                'controller' => 'index',
                'action'     => 'index'
            ]
        );
    }
}