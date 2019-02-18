<?php
namespace Modules\System\Permission\Controllers;



use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Permission\Models\ModelRoles;
use Modules\System\Permission\Tables\RoleResourcesTable;

class RoleResourcesController extends AdminController
{
    public function indexAction()
    {
        $roleId = $this->dispatcher->getParam('role_id');

        if(!is_numeric($roleId))
        {
            throw new Exception('Role does not exist');
        }

        $role = ModelRoles::findFirst($roleId);

        if(!$role)
        {
            throw new Exception('Role does not exist');
        }

        $this->tag->prependTitle(T::_('role_resources_manager'));
        $table = new RoleResourcesTable('role_resources_table', $roleId);

        $this->view->table = $table->process();
    }
}