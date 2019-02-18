<?php
namespace Modules\System\PageManager\Controllers;

use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\System\PageManager\DTE\Table\TablePageManager;

class PageManagerController extends AdminController
{
    public function indexAction()
    {
        $this->tag->prependTitle(T::_('page_manager'));
        $table = new TablePageManager('page_manager_table');
        $this->view->table = $table->process();
    }
}