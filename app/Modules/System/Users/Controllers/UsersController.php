<?php
namespace Modules\System\Users\Controllers;

use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\System\Users\Table\UsersTable;

class UsersController extends AdminController
{
    public function indexAction()
    {
        $this->tag->prependTitle(T::_('users_manager'));
        $table = new UsersTable('users_table');

        $this->view->table = $table->process();
    }
}