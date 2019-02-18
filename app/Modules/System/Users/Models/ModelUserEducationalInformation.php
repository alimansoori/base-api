<?php
namespace Modules\System\Users\Models;


use Lib\Mvc\Model;
use Modules\System\Users\Models\UserEducationalInformation\Properties;
use Modules\System\Users\Models\UserEducationalInformation\Validation;
use Phalcon\Mvc\Model\Relation;

/**
 * @method ModelUsers getUser()
 */
class ModelUserEducationalInformation extends Model
{
    use Properties;
    use Validation;

    protected function init()
    {
        $this->setSource('user_educational_information');
        $this->setDbRef(true);
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