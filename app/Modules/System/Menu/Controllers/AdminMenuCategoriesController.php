<?php
namespace Modules\System\Menu\Controllers;


use Lib\Mvc\Controllers\AdminController;
use Modules\System\Menu\DTE\Tables\TableAdminMenuCategories;

class AdminMenuCategoriesController extends AdminController
{
    public function indexAction()
    {
        $table = new TableAdminMenuCategories('admin_menu_categories_table');

        $this->view->table = $table->process();
    }

}