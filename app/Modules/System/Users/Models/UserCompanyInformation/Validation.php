<?php
namespace Modules\System\Users\Models\UserCompanyInformation;


use Modules\System\Users\Models\ModelUsers;
use Phalcon\Validation\Validator\Alnum;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength;

/**
 * @property \Lib\Validation validator
 */
trait Validation
{
    protected function mainValidation()
    {
        $this->validateUserId();
        $this->validateType();
        $this->validateName();
        $this->validateEconomicCode();
        $this->validateNationalCode();
        $this->validateRegisterCode();
        $this->validateResponsibility();
        $this->validatePersonnelCode();
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

    private function validateType()
    {
        $this->validator->add(
            'type',
            new InclusionIn([
                'domain' => ['private', 'legal'],
                'allowEmpty' => true
            ])
        );
    }

    private function validateName()
    {
        $this->validator->add(
            'name',
            new StringLength([
                'max' => 70,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'name',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }

    private function validateEconomicCode()
    {
        $this->validator->add(
            'economic_code',
            new Numericality([
                'allowEmpty' => true
            ])
        );

        $this->validator->add(
            'economic_code',
            new StringLength([
                'min' => 12,
                'max' => 16,
                'allowEmpty' => true
            ])
        );
    }

    private function validateNationalCode()
    {
        $this->validator->add(
            'national_code',
            new Numericality([
                'allowEmpty' => true
            ])
        );

        $this->validator->add(
            'national_code',
            new StringLength([
                'min' => 11,
                'max' => 11,
                'allowEmpty' => true
            ])
        );
    }

    private function validateRegisterCode()
    {
        $this->validator->add(
            'register_code',
            new Numericality([
                'allowEmpty' => true
            ])
        );

        $this->validator->add(
            'register_code',
            new StringLength([
                'min' => 5,
                'max' => 20,
                'allowEmpty' => true
            ])
        );
    }

    private function validateResponsibility()
    {
        $this->validator->add(
            'responsibility',
            new StringLength([
                'max' => 70,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'responsibility',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }

    private function validatePersonnelCode()
    {
        $this->validator->add(
            'personnel_code',
            new StringLength([
                'max' => 20,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'personnel_code',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }
}