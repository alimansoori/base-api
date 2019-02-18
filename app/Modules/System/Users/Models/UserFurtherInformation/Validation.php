<?php
namespace Modules\System\Users\Models\UserFurtherInformation;

use Modules\System\Users\Models\ModelUsers;
use Phalcon\Validation\Validator\Alnum;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Url;

/**
 * Trait Validation
 * @property \Lib\Validation validator
 */
trait Validation
{
    protected function mainValidation()
    {
        $this->validateUserId();
        $this->validateUrl('profile_url');
        $this->validateUrl('blog_address');
        $this->validateSignature();
        $this->validateFavorites();
        $this->validateUrl('avatar_address');
        $this->validateDescription();
    }

    private function validateUserId()
    {
        $this->validator->add(
            'user_id',
            new InclusionIn([
                'domain' => array_column(
                    ModelUsers::find([
                        'columns'=> 'id',
                    ])->toArray(),
                    'id'
                ),
                'message' => 'user id does not in range'
            ])
        );
    }

    private function validateUrl($field)
    {
        $this->validator->add(
            $field,
            new Url([
                'cancelOnFail' => true,
                'allowEmpty' => true
            ])
        );

        $this->validator->add(
            $field,
            new StringLength([
                'max' => 255,
                'allowEmpty' => true
            ])
        );
    }

    private function validateSignature()
    {
//        $this->validator->add(
//            'signature',
//            new Regex([
//                'allowEmpty' => true
//            ])
//        );

        $this->validator->add(
            'signature',
            new StringLength([
                'max' => 255,
                'allowEmpty' => true
            ])
        );
    }

    private function validateFavorites()
    {
//        $this->validator->add(
//            'favorites',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );

        $this->validator->add(
            'favorites',
            new StringLength([
                'max' => 255,
                'allowEmpty' => true
            ])
        );
    }

    protected function validateDescription()
    {
        $this->validator->add(
            'description',
            new StringLength([
                'max' => 500,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'description',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }

}