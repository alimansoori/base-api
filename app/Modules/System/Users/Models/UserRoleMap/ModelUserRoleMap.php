<?php
namespace Modules\System\Users\Models\UserRoleMap;


use Lib\Mvc\Model;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Permission\Models\ModelRoles;

/**
 * @method ModelRoles getRole()
 */
class ModelUserRoleMap extends Model
{
    use Properties;
    use Validations;

    protected function init()
    {
        $this->setSource('user_role_map');
        $this->setDbRef(true);
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
    }

    public static function getRolesForUser( $userId)
    {
        /** @var ModelRoles[] $roles */
        $roles = ModelRoles::findByLanguageIso(ModelLanguage::getCurrentLanguage());

        $userRoles = [];

        foreach($roles as $role)
        {
            $userRoles[] = self::getUpdateDataForTable($role, $userId);
        }

        return $userRoles;
    }

    public static function getUpdateDataForTable( ModelRoles $role, $userId)
    {
        $status = 0;

        /** @var ModelUserRoleMap $userRole */
        $userRole = self::findFirst([
            'conditions' => 'user_id=:user_id: AND role_id=:role_id:',
            'bind' => [
                'user_id' => $userId,
                'role_id' => $role->getId()
            ]
        ]);

        if(!$userRole)
        {
            $status = 1;
        }
        if ($userRole && $userRole->getStatus() == 'active')
        {
            $status = 1;
        }

        $roleResource = [
            'DT_RowId'      => $role->getId(),
            'id'            => $role->getId(),
            'title'         => $role->getTitle(),
            'module'        => T::_($role->getModule()->getTitle()),
            'status'        => $status
        ];

        return $roleResource;
    }
}