<?php
namespace Modules\System\Users\Models\Users;


use Modules\System\Permission\Models\ModelRoles;
use Modules\System\Users\Models\ModelUserCompanyInformation;
use Modules\System\Users\Models\ModelUserEducationalInformation;
use Modules\System\Users\Models\ModelUserFurtherInformation;
use Modules\System\Users\Models\ModelUserPersonalInformation;
use Modules\System\Users\Models\ModelUserSettingInformation;
use Modules\System\Users\Models\UserRoleMap\ModelUserRoleMap;

/**
 * @method ModelUserSettingInformation      getSettingInformation()
 * @method ModelUserFurtherInformation      getFurtherInformation()
 * @method ModelUserEducationalInformation  getEducationalInformation()
 * @method ModelUserCompanyInformation      getCompanyInformation()
 * @method ModelUserPersonalInformation     getPersonalInformation()
 * @method ModelRoles                       getRoles()
 */
trait Relations
{
    protected function relations()
    {
        $this->hasManyToMany(
            'id',
            ModelUserRoleMap::class,
            'user_id', 'role_id',
            ModelRoles::class,
            'id',
            [
                'alias' => 'Roles'
            ]
        );

        $this->hasOne(
            'id',
            ModelUserSettingInformation::class,
            'user_id',
            [
                'alias' => 'SettingInformation'
            ]
        );
        $this->hasOne(
            'id',
            ModelUserFurtherInformation::class,
            'user_id',
            [
                'alias' => 'FurtherInformation'
            ]
        );
        $this->hasOne(
            'id',
            ModelUserEducationalInformation::class,
            'user_id',
            [
                'alias' => 'EducationalInformation'
            ]
        );
        $this->hasOne(
            'id',
            ModelUserCompanyInformation::class,
            'user_id',
            [
                'alias' => 'CompanyInformation'
            ]
        );
        $this->hasOne(
            'id',
            ModelUserPersonalInformation::class,
            'user_id',
            [
                'alias' => 'PersonalInformation'
            ]
        );
    }
}