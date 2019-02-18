<?php
namespace Modules\Projekt\CodePlayer;


use Lib\Module\RoutesModule;

class Routes extends RoutesModule
{
    public function init()
    {
        $this->router->add(
            '/codeplayers/{id:[0-9]+}',
            [
                'module' => $this->moduleName,
                'controller' => 'codeplayer',
                'action' => 'index'
            ],
            [
                'GET'
            ]
        )->setName('get_codeplayer');

        $this->router->add(
            '/codeplayers',
            [
                'module' => $this->moduleName,
                'controller' => 'codeplayer-create',
                'action' => 'index'
            ],
            [
                'POST'
            ]
        )->setName('create_codeplayer');

        $this->router->add(
            '/codeplayers/{id:[0-9]+}',
            [
                'module' => $this->moduleName,
                'controller' => 'codeplayer-edit',
                'action' => 'index'
            ],
            [
                'PUT'
            ]
        )->setName('edit_codeplayer');

        $this->router->add(
            '/codeplayers/{id:[0-9]+}',
            [
                'module' => $this->moduleName,
                'controller' => 'codeplayer-delete',
                'action' => 'index'
            ],
            [
                'DELETE'
            ]
        )->setName('delete_codeplayer');
    }
}