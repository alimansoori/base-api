<?php
namespace Modules\System\Permission\Models;


use Lib\Mvc\Model;
use Lib\Translate\T;
use Modules\System\Permission\Models\Resources\Properties;
use Modules\System\Permission\Models\Resources\Validation;
use Modules\System\Widgets\Models\ModelModules;

/**
 * @method ModelRoles[]             getRoles()
 * @method ModelRoleResourceMap[]   getRoleResourceMap()
 * @method ModelModules             getModule()
 */
class ModelResources extends Model
{
    use Properties;
    use Validation;

    public function init()
    {
        $this->setDbRef(true);
        $this->setSource('resources');
    }

    protected function relations()
    {
        $this->hasManyToMany(
            'id',
            ModelRoleResourceMap::class,
            'resource_id', 'role_id',
            ModelRoles::class,
            'id',
            [
                'alias' => 'Roles'
            ]
        );

        $this->hasMany(
            'id',
            ModelRoleResourceMap::class,
            'resource_id',
            [
                'alias' => 'RoleResourceMap'
            ]
        );

        $this->belongsTo(
            'module_id',
            ModelModules::class,
            'id',
            [
                'alias' => 'Module'
            ]
        );
    }

    public static function getTableInformation()
    {
        /** @var ModelResources[] $resources */
        $resources = self::find();

        $row = [];

        foreach( $resources as $role )
        {
            $row[] = self::getResourceForTable($role);
        }

        return $row;
    }

    public static function getResourceForTable( ModelResources $resource)
    {
        return [
            'DT_RowId' => $resource->getId(),
            'id' => $resource->getId(),
            'title' => $resource->getTitle(),
            'controller' => $resource->getController(),
            'action' => $resource->getAction(),
            'module_id' => [
                'display' => T::_($resource->getModule()->getTitle()),
                'sort' => T::_($resource->getModule()->getTitle()),
                'filter' => T::_($resource->getModule()->getTitle()),
                '_' => $resource->getModuleId(),
            ],
            'roles' => array_column(
                $resource->getRoleResourceMap()->toArray(),
                'role_id'
            )
        ];
    }
}