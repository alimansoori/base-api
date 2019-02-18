<?php
namespace Modules\System\Users\Models\UserRoleMap;


use Lib\Validation;
use Modules\System\Permission\Models\ModelRoles;
use Modules\System\Users\Models\ModelUsers;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * @property Validation $validator
 */
trait Validations
{
    protected function mainValidation()
    {
        $this->validator->add('user_id',
            new InclusionIn([
                'domain' => array_column(ModelUsers::find(['columns' => 'id'])->toArray(),'id'),
                'cancelOnFail' => true
            ])
        );
        /*
         * role_id
         */

        $this->validator->add('role_id',
            new InclusionIn([
                'domain' => array_column(ModelRoles::find(['columns' => 'id'])->toArray(),'id'),
                'cancelOnFail' => true
            ])
        );
    }
}