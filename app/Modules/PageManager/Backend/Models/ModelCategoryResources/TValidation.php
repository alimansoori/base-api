<?php
namespace Modules\PageManager\Backend\Models\ModelCategoryResources;

use Lib\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

/**
 * @property Validation $validator
 */
trait TValidation
{
    protected function mainValidation()
    {
        $this->validTitle();
        $this->validDescription();
    }

    private function validTitle()
    {
        $this->validator->add(
            'title',
            new PresenceOf([
                'cancelOnFail' => true
            ])
        );

        $this->validator->add(
            'title',
            new StringLength([
                'max' => 30
            ])
        );
    }

    private function validDescription()
    {
        $this->validator->add(
            'description',
            new StringLength([
                'min' => 10,
                'max' => 200,
                'allowEmpty' => true
            ])
        );
    }
}