<?php
namespace Modules\System\Widgets\Models\Modules;

use Lib\Module\ModuleManager;
use Lib\Validation;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * @property Validation validator
 */
trait Validations
{
    protected function mainValidation()
    {
        $this->validateName();
        $this->validateTitle();
        $this->validateDescription();
        $this->validatePosition();
    }

    private function validateName()
    {
        $this->validator->add(
            'name',
            new Uniqueness([
                'model' => $this
            ])
        );

        $this->validator->add(
            'name',
            new InclusionIn([
                'domain' => array_keys(ModuleManager::getAllModules())
            ])
        );
    }

    private function validateTitle()
    {
        $this->validator->add(
            'title',
            new StringLength([
                'max' => 70
            ])
        );
    }

    private function validateDescription()
    {
        $this->validator->add(
            'description',
            new StringLength([
                'max' => 200,
                'allowEmpty' => true
            ])
        );
    }
}