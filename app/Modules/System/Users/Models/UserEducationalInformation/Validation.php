<?php
namespace Modules\System\Users\Models\UserEducationalInformation;


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
        $this->validateLevel();
        $this->validateField();
    }

    private function validateUserId()
    {
        $this->validator->add(
            'user_id',
            new InclusionIn( [
                'domain'  => array_column(
                    ModelUsers::find( [
                        'columns' => 'id',
                    ] )->toArray(),
                    'id'
                ),
                'message' => 'user id does not in range'
            ] )
        );
    }

    private function validateLevel()
    {
        $this->validator->add(
            'level',
            new InclusionIn([
                'domain' => [
                    'associate',
                    'bachelor',
                    'master',
                    'doctorate'
                ]
            ])
        );

//        $this->validator->add(
//            'level',
//            new Alnum( [
//                'allowEmpty' => true
//            ] )
//        );
    }

    private function validateField()
    {
        $this->validator->add(
            'field',
            new StringLength( [
                'max'        => 50,
                'allowEmpty' => true
            ] )
        );

//        $this->validator->add(
//            'field',
//            new Alnum( [
//                'allowEmpty' => true
//            ] )
//        );
    }
}