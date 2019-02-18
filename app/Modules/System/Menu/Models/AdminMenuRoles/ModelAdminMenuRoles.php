<?php
namespace Modules\System\Menu\Models\AdminMenuRoles;


use Lib\Mvc\Model;
use Modules\System\Menu\Models\AdminMenu\ModelAdminMenu;
use Modules\System\Permission\Models\ModelRoles;

/**
 * @property ModelAdminMenu adminMenu
 * @method   ModelAdminMenu getAdminMenu()
 * @property ModelRoles     role
 * @method   ModelRoles     getRole()
 */
class ModelAdminMenuRoles extends Model
{
    use Properties;
    use Relations;

    public function init()
    {
        $this->setDbRef(true);
        $this->setSource('admin_menu_roles');
    }

    protected function relations()
    {
        $this->belongsTo(
            'admin_menu_id',
            ModelAdminMenu::class,
            'id',
            [
                'alias' => 'AdminMenu',
                'foreignKey' => [
                    'message' => 'this manage does not exist in ModelAdminMenu'
                ]
            ]
        );

        $this->belongsTo(
            'role_id',
            ModelRoles::class,
            'id',
            [
                'alias' => 'Role',
                'foreignKey' => [
                    'message' => 'this role does not exist'
                ]
            ]
        );
    }

}