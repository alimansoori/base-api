<?php
namespace Modules\System\Permission\Models;


use Lib\Mvc\Model;
use Lib\Translate\T;
use Modules\System\Permission\Models\ModelResources;
use Modules\System\Permission\Models\ModelRoles;
use Modules\System\Permission\Models\RoleResourceMap\Properties;
use Modules\System\Permission\Models\RoleResourceMap\Validation;
use Phalcon\Di;
use Phalcon\Mvc\Model\Manager;

/**
 * @method ModelRoles     getRole()
 * @method ModelResources getResource()
 */
class ModelRoleResourceMap extends Model
{
    use Properties;
    use Validation;

    public function init()
    {
        $this->setDbRef(true);
        $this->setSource('role_resource_map');
    }

    protected function relations()
    {
        $this->belongsTo(
            'role_id',
            ModelRoles::class,
            'id',
            [
                'alias' => 'Role'
            ]
        );

        $this->belongsTo(
            'resource_id',
            ModelResources::class,
            'id',
            [
                'alias' => 'Resource'
            ]
        );
    }

    public static function getResourcesForRole($roleId)
    {
        /** @var ModelResources[] $resources */
        $resources = ModelResources::find();

        $roleResource = [];

        foreach($resources as $resource)
        {
            $roleResource[] = self::getUpdateDataForTable($resource, $roleId);
        }

        return $roleResource;
    }

    public static function getUpdateDataForTable(ModelResources $resource, $roleId)
    {
        $status = 0;

        /** @var ModelRoleResourceMap $resourceRole */
        $resourceRole = self::findFirst([
            'conditions' => 'role_id=:role_id: AND resource_id=:res_id:',
            'bind' => [
                'role_id' => $roleId,
                'res_id' => $resource->getId()
            ]
        ]);
        if($resourceRole && $resourceRole->getStatus() == 'allow')
        {
            $status = 1;
        }

        $roleResource = [
            'DT_RowId'      => $resource->getId(),
            'id'            => $resource->getId(),
            'title'         => $resource->getTitle(),
            'module'        => T::_($resource->getModule()->getTitle()),
            'controller'    => $resource->getController(),
            'action'        => $resource->getAction(),
            'status'        => $status
        ];

        return $roleResource;
    }
}