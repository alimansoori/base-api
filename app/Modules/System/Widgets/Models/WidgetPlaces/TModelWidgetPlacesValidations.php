<?php

namespace Modules\System\Widgets\Models\WidgetPlaces;

use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * @property \Lib\Validation validator
 */
trait TModelWidgetPlacesValidations
{
    public function mainValidation()
    {
        $this->validationName();

        $this->validationValue();

    }
    private function validationName()
    {
        $this->validator->add(
            'name',
            new PresenceOf(
                [
                    'message' => 'The :field is required',
                    'cancelOnFail' => true
                ]
            )
        );
        $this->validator->add(
            'name',
            new StringLength(
                [
                    'max' => 45,
                    'messageMaximum' => ':field length is too long',
                    'cancelOnFail' => true
                ]
            )
        );
        $this->validator->setFilters('name',['trim','striptags','alphanum']);
    }
    private function validationValue()
    {
        $this->validator->add(
            'value',
            new PresenceOf(
                [
                    'message' => 'The :field is required',
                    'cancelOnFail' => true
                ]
            )
        );
        $this->validator->add(
            'value',
            new StringLength(
                [
                    'max' => 20,
                    'messageMaximum' => ':field length is too long',
                    'cancelOnFail' => true
                ]
            )
        );
        $this->validator->add(
            'value',
            new Uniqueness(
                [
                    'message' =>'the :field is not unique',
                    'domain' => self::class,
                    'cancelOnFail' => true
                ]
            )
        );
        $this->validator->setFilters('value',['trim','striptags','alphanum']);
    }

}