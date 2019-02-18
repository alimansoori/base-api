<?php
namespace Modules\System\Widgets\Controllers;

use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\System\Widgets\Tables\ModulesTable;

class ModulesController extends AdminController
{
    public function indexAction()
    {
        $this->tag->prependTitle(T::_('modules_manager'));
        $table = new ModulesTable('modules_table');

        $this->view->table = $table->process();
    }
}