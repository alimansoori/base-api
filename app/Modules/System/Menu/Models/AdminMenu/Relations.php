<?php
namespace Modules\System\Menu\Models\AdminMenu;


use Modules\System\Menu\Models\AdminMenuCategory\ModelAdminMenuCategory;
use Modules\System\Menu\Models\AdminMenuRoles\ModelAdminMenuRoles;
use Modules\System\Menu\Models\ModelAdminMenuTranslate;
use Modules\System\Permission\Models\ModelRoles;
use Phalcon\Mvc\Model\Relation;

/**
 * @property ModelRoles[]               roles
 * @property ModelAdminMenuRoles[]      rolesMap
 * @method   ModelRoles[]               getRoles()
 * @method   ModelAdminMenuRoles[]      getRolesMap()
 * @property ModelAdminMenu[]           childs
 * @method   ModelAdminMenu[]           getChilds()
 * @method   ModelAdminMenuTranslate[]  getTranslates()
 * @property ModelAdminMenu             parent
 * @method   ModelAdminMenu             getParent()
 * @property ModelAdminMenuCategory     manage
 * @method   ModelAdminMenuCategory     getCategory()
 */
trait Relations
{
    protected function relations()
    {
        $this->hasManyToMany(
            'id',
            ModelAdminMenuRoles::class,
            'admin_menu_id', 'role_id',
            ModelRoles::class,
            'id',
            [
                'alias' => 'Roles'
            ]
        );

        $this->hasMany(
            'id',
            ModelAdminMenuRoles::class,
            'role_id',
            [
                'alias' => 'RolesMap',
                'foreignKey' => [
                    'message' => 'The this menu cannot be deleted because other menu are using it',
                    'action' => Relation::ACTION_CASCADE
                ]
            ]
        );

        $this->hasMany(
            'id',
            self::class,
            'parent_id',
            [
                'alias' => 'Childs',
                'foreignKey' => [
                    'message' => 'The this menu cannot be deleted because other menu are using it',
                ]
            ]
        );

        $this->hasMany(
            'id',
            ModelAdminMenuTranslate::class,
            'menu_id',
            [
                'alias' => 'Translates',
                'foreignKey' => [
                    'action' => Relation::ACTION_CASCADE
                ]
            ]
        );

        $this->belongsTo(
            'parent_id',
            self::class,
            'id',
            [
                'alias' => 'Parent',
                'foreignKey' => [
                    'allowNulls' => true,
                    'message' => 'The parent_id does not exist on the admin menu model'
                ]
            ]
        );

        $this->belongsTo(
            'category_id',
            ModelAdminMenuCategory::class,
            'id',
            [
                'alias' => 'Category',
                'foreignKey' => [
                    'message' => 'this manage does not exist'
                ]
            ]
        );
    }
}