<?php
namespace Modules\System\Users\Models\UserPersonalInformation;

use Modules\System\Users\Models\ModelUsers;
use Phalcon\Validation\Validator\Alnum;
use Phalcon\Validation\Validator\Date;
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
        $this->validateFirstName();
        $this->validateLastName();
        $this->validateParentName();
        $this->validateIdNumber();
        $this->validatePlaceOfBirth();
        $this->validateGender();
        $this->validateDateOfBirth();
        $this->validateNationalCode();
        $this->validatePostalCode();
        $this->validateState();
        $this->validateCity();
        $this->validateMobile();
        $this->validatePhone();
        $this->validateFax();
        $this->validateAddress();
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

    private function validateFirstName()
    {
        $this->validator->add(
            'first_name',
            new StringLength([
                'max' => 40,
                'min' => 2,
                'allowEmpty' => true
            ])
        );
//
//        $this->validator->add(
//            'first_name',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }

    private function validateLastName()
    {
        $this->validator->add(
            'last_name',
            new StringLength([
                'max' => 40,
                'min' => 2,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'last_name',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }

    private function validateParentName()
    {
        $this->validator->add(
            'parent_name',
            new StringLength([
                'max' => 40,
                'min' => 2,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'parent_name',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }

    private function validateIdNumber()
    {
        $this->validator->add(
            'id_number',
            new Numericality([
                'allowEmpty' => true
            ])
        );

        $this->validator->add(
            'id_number',
            new StringLength([
                'min' => 1,
                'max' => 10,
                'allowEmpty' => true
            ])
        );
    }

    private function validateGender()
    {
        $this->validator->add(
            'gender',
            new InclusionIn([
                'domain' => ['male', 'female'],
                'allowEmpty' => true
            ])
        );
    }

    private function validateDateOfBirth()
    {
        if(!$this->getDateOfBirth())
        {
            $this->setDateOfBirth(null);
        }

        $this->validator->add(
            'date_of_birth',
            new Date([
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
                'min' => 10,
                'max' => 10,
                'allowEmpty' => true
            ])
        );
    }

    private function validatePostalCode()
    {
        $this->validator->add(
            'postal_code',
            new Numericality([
                'allowEmpty' => true
            ])
        );

        $this->validator->add(
            'postal_code',
            new StringLength([
                'min' => 10,
                'max' => 10,
                'allowEmpty' => true
            ])
        );
    }

    private function validatePlaceOfBirth()
    {
        $this->validator->add(
            'place_of_birth',
            new StringLength([
                'max' => 40,
                'min' => 2,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'place_of_birth',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }

    private function validateState()
    {
        $this->validator->add(
            'state',
            new StringLength([
                'max' => 40,
                'min' => 2,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'state',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }

    private function validatePhone()
    {
        $this->validator->add(
            'phone',
            new StringLength([
                'max' => 14,
                'min' => 5,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'phone',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }

    private function validateMobile()
    {
        $this->validator->add(
            'mobile',
            new StringLength([
                'max' => 14,
                'min' => 11,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'mobile',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }

    private function validateFax()
    {
        $this->validator->add(
            'fax',
            new StringLength([
                'max' => 14,
                'min' => 5,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'fax',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }

    private function validateCity()
    {
        $this->validator->add(
            'city',
            new StringLength([
                'max' => 40,
                'min' => 2,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'city',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }

    private function validateAddress()
    {
        $this->validator->add(
            'address',
            new StringLength([
                'max' => 200,
                'min' => 12,
                'allowEmpty' => true
            ])
        );

//        $this->validator->add(
//            'address',
//            new Alnum([
//                'allowEmpty' => true
//            ])
//        );
    }
}