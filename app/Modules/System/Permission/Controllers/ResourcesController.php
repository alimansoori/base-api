<?php
namespace Modules\System\Permission\Controllers;



use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\System\Permission\Tables\ResourcesTable;

class ResourcesController extends AdminController
{
    public function indexAction()
    {
        $this->tag->prependTitle(T::_('resources_manager'));
        $table = new ResourcesTable('resources_table');

        $this->view->table = $table->process();
    }
}