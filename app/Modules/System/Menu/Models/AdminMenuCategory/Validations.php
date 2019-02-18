<?php
namespace Modules\System\Menu\Models\AdminMenuCategory;


use Lib\Validation;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

/**
 * @property Validation validator
 */
trait Validations
{
    protected function mainValidation()
    {
        $this->positionValidation();
    }

    private function positionValidation()
    {
        $this->validator->add(
            'position',
            new Numericality([
                'allowEmpty' => true
            ])
        );
    }
}