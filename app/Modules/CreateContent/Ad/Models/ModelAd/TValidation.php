<?php
namespace Modules\CreateContent\Ad\Models\ModelAd;

use Lib\Validation;
use Modules\CreateContent\Ad\Models\ModelCategory;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

/**
 * @property Validation $validator
 */
trait TValidation
{
    protected function mainValidation()
    {
        $this->validCategoryId();
        $this->validTitle();
        $this->validDescription();
    }

    private function validCategoryId()
    {
        $this->validator->add(
            'category_id',
            new InclusionIn([
                'domain' => array_keys(ModelCategory::getLeaves())
            ])
        );
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
                'max' => 50
            ])
        );
    }

    private function validDescription()
    {
        $this->validator->add(
            'description',
            new StringLength([
                'min' => 10,
                'max' => 1000
            ])
        );
    }
}