<?php
namespace Modules\System\Permission\Controllers;



use Lib\Module\ModuleManager;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\System\Permission\Tables\RolesTable;

class RolesController extends AdminController
{
    public function indexAction()
    {
        $this->tag->prependTitle(T::_('roles_manager'));
        $table = new RolesTable('roles_table');

        $this->view->table = $table->process();
    }
}