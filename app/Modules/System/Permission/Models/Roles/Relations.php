<?php
namespace Modules\System\Permission\Models\Roles;


use Modules\System\Permission\Models\ModelRoles;
use Modules\System\Permission\Models\ModelRolesTranslate;
use Modules\System\Widgets\Models\ModelModules;
use Modules\System\Users\Models\ModelUsers;
use Modules\System\Users\Models\UserRoleMap\ModelUserRoleMap;
use Modules\System\PageManager\Models\PageRoleMap\ModelPageRoleMap;
use Modules\System\PageManager\Models\Pages\ModelPages;
use Modules\System\Permission\Models\ModelResources;
use Modules\System\Permission\Models\ModelRoleResourceMap;
use Phalcon\Mvc\Model\Relation;

/**
 * @method ModelPages[]             getPages()
 * @method ModelRoles               getModule()
 * @method ModelUsers[]             getUsers()
 * @method ModelPageRoleMap[]       getPageRoleMaps()
 * @method ModelResources[]         getResources()
 * @method ModelRolesTranslate[]    getTranslates()
 * @method ModelRoleResourceMap     getRoleResourceMaps()
 */
trait Relations
{
    public function relations()
    {
        $this->belongsTo(
            'module_id',
            ModelModules::class,
            'id',
            [
                'alias' => 'Module'
            ]
        );

        $this->hasMany(
            'id',
            ModelPageRoleMap::class,
            'role_id',
            [
                'alias' => 'PageRoleMaps'
            ]
        );

        $this->hasMany(
            'id',
            ModelRolesTranslate::class,
            'role_id',
            [
                'alias' => 'Translates',
                'action' => Relation::ACTION_CASCADE
            ]
        );

        $this->hasManyToMany(
            'id',
            ModelUserRoleMap::class,
            'role_id', 'user_id',
            ModelUsers::class,
            'id',
            [
                'alias' => 'Users'
            ]
        );

        $this->hasManyToMany(
            'id',
            ModelPageRoleMap::class,
            'role_id', 'page_id',
            ModelPages::class,
            'id',
            [
                'alias' => 'Pages'
            ]
        );

        $this->hasManyToMany(
            'id',
            ModelRoleResourceMap::class,
            'role_id', 'resource_id',
            ModelResources::class,
            'id',
            [
                'alias' => 'Resources'
            ]
        );

        $this->hasMany(
            'id',
            ModelRoleResourceMap::class,
            'role_id',
            [
                'alias' => 'RoleResourceMaps'
            ]
        );
    }
}