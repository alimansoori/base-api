<?php
namespace Modules\System\Users\Models\UserSettingInformation;


use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Users\Models\ModelUsers;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Regex;

/**
 * @property \Lib\Validation validator
 */
trait Validation
{
    protected function mainValidation()
    {
        $this->validateUserId();
        $this->validateTimeZone();
        $this->validateLanguageIso();
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

    private function validateTimeZone()
    {
        $this->validator->add(
            'time_zone',
            new Regex([
                'pattern' => '/^[+-][0-9]{2}:[0-9]{2}$/',
                'allowEmpty' => true
            ])
        );
    }

    private function validateLanguageIso()
    {
        $this->validator->add(
            'language_iso',
            new InclusionIn([
                'domain' => ModelLanguage::getLanguages(),
                'allowEmpty' => true
            ])
        );
    }
}