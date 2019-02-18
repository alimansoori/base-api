<?php
namespace Modules\System\Users\Models;


use Lib\Mvc\Model;
use Modules\System\Users\Models\UserSettingInformation\Properties;
use Modules\System\Users\Models\UserSettingInformation\Validation;
use Phalcon\Mvc\Model\Relation;

/**
 * @method ModelUsers getUser()
 */
class ModelUserSettingInformation extends Model
{
    use Properties;
    use Validation;

    protected function init()
    {
        $this->setDbRef(true);
        $this->setSource('user_setting_information');
    }

    protected function relations()
    {
        $this->belongsTo(
            'user_id',
            ModelUsers::class,
            'id',
            [
                'alias' => 'User',
                'action' => Relation::ACTION_CASCADE
            ]
        );
    }
}