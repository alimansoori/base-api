<?php
namespace Modules\System\Permission\Models\Resources;

use Modules\System\Widgets\Models\ModelModules;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

/**
 * @property \Lib\Validation $validator
 */
trait Validation
{
    protected function mainValidation()
    {
        $this->validateModuleId();
        $this->validateTitle();
    }

    protected function validateModuleId()
    {
        $this->validator->add(
            'module_id',
            new InclusionIn([
                'domain' => array_column(
                    ModelModules::find(['columns' => 'id'])->toArray(),
                    'id'
                )
            ])
        );
    }

    protected function validateTitle()
    {
        $this->validator->add('title',
            new PresenceOf([
                'cancelOnFail' => true
            ])
        );

        $this->validator->add('title',
            new StringLength([
                "max"            => 70,
                "min"            => 2,
                'cancelOnFail' => true
            ])
        );
    }

    protected function validateController()
    {
        $this->validator->add('controller',
            new PresenceOf([
                'cancelOnFail' => true
            ])
        );

        $this->validator->add('controller',
            new StringLength([
                "max"            => 100,
                "min"            => 2,
                'cancelOnFail' => true
            ])
        );
    }

    protected function validateAction()
    {
        $this->validator->add('action',
            new PresenceOf([
                'cancelOnFail' => true
            ])
        );

        $this->validator->add('action',
            new StringLength([
                "max"            => 100,
                "min"            => 2,
                'cancelOnFail' => true
            ])
        );
    }
}