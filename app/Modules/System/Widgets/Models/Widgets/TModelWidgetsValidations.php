<?php

namespace Modules\System\Widgets\Models\Widgets;

use Lib\Mvc\Model\WidgetPlaces\ModelWidgetPlaces;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\Callback;


trait TModelWidgetsValidations
{
    public function mainValidation()
    {
    }
}