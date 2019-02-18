<?php
namespace Modules\System\Permission\Models;


use Lib\Mvc\Model;
use Lib\Translate\T;
use Modules\System\Permission\Models\Roles\Events;
use Modules\System\Permission\Models\Roles\Properties;
use Modules\System\Permission\Models\Roles\Relations;
use Modules\System\Permission\Models\Roles\Validations;

class ModelRoles extends Model
{
    use Properties;
    use Relations;
    use Validations;
    use Events;

    protected function init()
    {
        $this->setSource('roles');
        $this->setDbRef(true);
    }

    /**
     * Find all roles except one
     *
     * @param string $except
     * @return \Phalcon\Mvc\Model\ResultsetInterface
     */
    public static function findAllExceptByName($except)
    {
        return self::find([
            'conditions' => 'title <> :title: AND status=:status:',
            'bind' => [
                'title' => $except,
                'status' => 'active'
            ]
        ]);
    }

    public static function getUsersTableInformation()
    {
        /** @var ModelRoles[] $roles */
        $roles = self::find();

        $row = [];

        foreach( $roles as $role )
        {
            $row[] = self::getRoleForTable($role);
        }

        return $row;
    }

    public static function getRoleForTable(ModelRoles $role)
    {
        return array_merge(
            $role->toArray(),
            [
                'DT_RowId' => $role->getId(),
                'related_module' => [
                    'display' => T::_($role->getModule()->getTitle()),
                    'sort' => T::_($role->getModule()->getTitle()),
                    'filter' => T::_($role->getModule()->getTitle()),
                    '_' => $role->getModule()->getTitle(),
                ]
            ]
        );
    }

    public static function isRole(int $roleId): bool
    {
        $role = self::findFirst($roleId);
        if($role) return true;
        return false;
    }
}