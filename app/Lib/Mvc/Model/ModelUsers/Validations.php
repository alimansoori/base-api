<?php
namespace Lib\Mvc\ModelUsers;

use Lib\Validation;
use Modules\System\Users\Models\ModelUsers;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * @property Validation validator
 */
trait Validations
{
    protected function mainValidation()
    {
       /*
        * email
        */
        $this->validator->add('email',
        new Email([
            'massage' => 'The e-mail is not valid',
            'cancelOnFail' => true
         ])
        );

        $this->validator->add('email',
            new PresenceOf([
                'massage' => 'The e-mail is required',
                'cancelOnFail' => true
            ])
        );

        $this->validateUsername();
    }

    private function validateUsername()
    {
        $this->validator->add('username',
            new PresenceOf([
                'massage' => 'The username is required',
                'cancelOnFail' => true
            ])
        );

        $this->validator->add('username',
            new StringLength( [
                "max"            => 20,
                "min"            => 2,
                "messageMaximum" => "username is too long!",
                "messageMinimum" => "username is too short!",
                'cancelOnFail' => true
            ] )
        );

        if($this->isModeCreate())
            $this->validator->add('username',
                new Uniqueness([
                    'model' => new ModelUsers(),
                    'message' => 'The inputted username is existing',
                    'cancelOnFail' => true
                ])
            );
        elseif($this->isModeUpdate())
        {
            /** @var ModelUsers $user */
            $user = self::findFirst($this->getId());
            if(!$user)
                return false;

            if($user->getUsername() != $this->getUsername())
            {
                $this->validator->add('username',
                    new Uniqueness([
                        'model' => new ModelUsers(),
                        'message' => 'The inputted username is existing',
                        'cancelOnFail' => true
                    ])
                );
            }
        }
    }
}