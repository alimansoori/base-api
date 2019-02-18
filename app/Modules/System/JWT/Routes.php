<?php
namespace Modules\System\JWT;


use Lib\Module\RoutesModule;

class Routes extends RoutesModule
{
    public function init()
    {
        $this->router->add(
            "/ttt",
            [
                'module' => $this->moduleName,
                'controller' => 'index',
                'action' => 'index'
            ]
        );
    }
}