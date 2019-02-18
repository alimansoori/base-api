<?php
namespace Modules\Users\Session;


use Lib\Module\RoutesModule;

class Routes extends RoutesModule
{
    public function init()
    {
        $this->router->add(
            '/login',
            [
                'module' => $this->moduleName,
                'controller' => 'login',
                'action' => 'index'
            ],
            [
                'POST'
            ]
        )->setName('login');

        $this->router->add(
            '/register',
            [
                'module' => $this->moduleName,
                'controller' => 'register',
                'action' => 'index'
            ],
            [
                'POST'
            ]
        )->setName('register');
    }
}