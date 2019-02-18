<?php
namespace Modules\System\Permission\Models\RoleResourceMap;

use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Permission\Models\ModelResources;
use Modules\System\Permission\Models\ModelRoles;
use Phalcon\Validation\Validator\InclusionIn;

/**
 * @property \Lib\Validation $validator
 */
trait Validation
{
    protected function mainValidation()
    {
        $this->validateRoleId();
        $this->validateResourceId();
    }

    protected function validateRoleId()
    {
        $this->validator->add(
            'role_id',
            new InclusionIn([
                'domain' => array_column(
                    ModelRoles::find([
                        'columns' => 'id',
                        'conditions' => 'language_iso = :lang:',
                        'bind' => [
                            'lang' => ModelLanguage::getCurrentLanguage()
                        ]
                    ])->toArray(),
                    'id'
                )
            ])
        );
    }

    protected function validateResourceId()
    {
        $this->validator->add(
            'resource_id',
            new InclusionIn([
                'domain' => array_column(
                    ModelResources::find([
                        'columns' => 'id'
                    ])->toArray(),
                    'id'
                )
            ])
        );
    }
}