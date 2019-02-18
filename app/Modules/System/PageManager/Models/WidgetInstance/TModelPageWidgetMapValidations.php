<?php

namespace Modules\System\PageManager\Models\WidgetInstance;

use Modules\System\Widgets\Models\WidgetPlaces\ModelWidgetPlaces;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\StringLength;


trait TModelPageWidgetMapValidations
{
    public function mainValidation()
    {
        $this->validationPlace();
    }

    private function validationPlace()
    {
        $this->validator->add(
            'place',
            new PresenceOf(
                [
                    'message' => 'The :field is required',
                    'cancelOnFail' => true
                ]
            )
        );

        //'place' should select from 'value' column in Widget-Places table
        $this->validator->add(
            'place',
            new InclusionIn(
                [
                    'message' => 'this value is not exist in Widget-Places table',
                    'domain' => array_column(ModelWidgetPlaces::find()->toArray(),'value'),
                    'cancelOnFail' => true
                ]
            )
        );
        $this->validator->add(
            'place',
            new StringLength(
                [
                    'max' => 20,
                    'messageMaximum' => ':field length is too long',
                    'cancelOnFail' => true
                ]
            )
        );
    }
}