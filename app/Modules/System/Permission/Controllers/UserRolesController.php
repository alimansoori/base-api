<?php
namespace Modules\System\Permission\Controllers;



use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Permission\Models\ModelRoles;
use Modules\System\Permission\Tables\RoleResourcesTable;
use Modules\System\Permission\Tables\UserRolesTable;
use Modules\System\Users\Models\ModelUsers;
use Modules\System\Users\Models\UserRoleMap\ModelUserRoleMap;

class UserRolesController extends AdminController
{
    public function indexAction()
    {
        $userId = $this->dispatcher->getParam('user_id');

        if(!is_numeric($userId))
        {
            throw new Exception('User does not exist');
        }

        $role = ModelUsers::findFirst($userId);

        if(!$role)
        {
            throw new Exception('User does not exist');
        }

        $this->tag->prependTitle(T::_('role_resources_manager'));
        $table = new UserRolesTable('user_roles_table', $userId);

        $this->view->table = $table->process();
    }
}