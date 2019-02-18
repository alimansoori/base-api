<?php

namespace Modules\System\Menu\DTE\Tables;


use Lib\DTE\Table;
use Lib\DTE\Table\Buttons\Editor\ButtonCreate;
use Lib\DTE\Table\Buttons\Editor\ButtonEdit;
use Lib\DTE\Table\Buttons\Editor\ButtonRemove;
use Lib\DTE\Table\Column;
use Modules\System\Menu\Models\AdminMenuCategory\ModelAdminMenuCategory;
use Modules\System\Menu\Models\AdminMenuRoles\ModelAdminMenuRoles;

class TableAdminMenuRoles extends Table
{
    public function init()
    {
//        $this->rowGroup()->setDataSrc('category_title');
    }

    public function data()
    {
        $result = [];
        $roles = ModelAdminMenuRoles::find([
            'conditions' => 'admin_menu_id=:menuid:',
            'bind' => [
                'menuid' => $this->request->getPost('id_from_parent')
            ]
        ]);

        /** @var ModelAdminMenuRoles $role */
        foreach($roles as $role)
        {
            $row = [];
            $row['DT_RowId'] = 'row_'. $role->getId();

            $result[] = array_merge($role->toArray(), $row);

        }
        return $result;
    }

    public function columns()
    {
        $this->columnRole();
//        $this->columnPosition();
    }

    public function buttons()
    {
        $create = new ButtonCreate();
        $this->addButton($create);

        $edit = new ButtonEdit();
        $this->addButton($edit);

        $remove = new ButtonRemove();
        $this->addButton($remove);
    }

    private function columnRole()
    {
        $role = new Column('role');
        $role->setLabel('Role');
        $role->setData('role');
        $this->addColumn($role);
    }

}