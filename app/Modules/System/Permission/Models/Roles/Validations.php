<?php
namespace Modules\System\Permission\Models\Roles;


use Modules\System\Widgets\Models\ModelModules;
use Lib\Validation;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Validation\Validator\Alnum;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Lib\Validation\Validator\MyUniqueness;

/**
 * @property Validation validator
 */
trait Validations
{
    public function mainValidation()
    {
        $this->validateModuleId();
        $this->validateLanguageIso();
        $this->validateName();
        $this->validateTitle();
        $this->validateDescription();
        $this->validateStatus();
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

    protected function validateLanguageIso()
    {
        $this->validator->add(
            'language_iso',
            new InclusionIn([
                'domain' => array_column(
                    ModelLanguage::find(['columns' => 'iso'])->toArray(),
                    'iso'
                )
            ])
        );

        $this->validator->add(
            'language_iso',
            new Identical([
                'accepted' => ModelLanguage::getCurrentLanguage()
            ])
        );
    }

    protected function validateName()
    {
        $this->validator->add(
            'name',
            new MyUniqueness([
                'model' => $this,
                'languageCheck' => true,
                'parentCheck' => false,
            ])
        );

        $this->validator->add(
            'name',
            new Alnum([
                'cancelOnFail' => true
            ])
        );

        $this->validator->add('name',
            new StringLength([
                "max"            => 30,
                "min"            => 2,
                'cancelOnFail' => true
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
                "max"            => 30,
                "min"            => 2,
                'cancelOnFail' => true
            ])
        );
    }

    protected function validateDescription()
    {
        $this->validator->add('description',
            new StringLength(
                [
                    "max"            => 200,
                    "min"            => 2,
                    'allowEmpty' => true,
                    'cancelOnFail' => true
                ] )
        );
    }

    protected function validateStatus()
    {
        $this->validator->add(
            'status',
            new InclusionIn([
                'domain' => ['active', 'inactive'],
                'allowEmpty' => true
            ])
        );
    }
}