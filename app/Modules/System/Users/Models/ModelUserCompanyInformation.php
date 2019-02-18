<?php
namespace Modules\System\Users\Models;


use Lib\Mvc\Model;
use Modules\System\Users\Models\UserCompanyInformation\Properties;
use Modules\System\Users\Models\UserCompanyInformation\Validation;
use Phalcon\Mvc\Model\Relation;

/**
 * @method ModelUsers getUser()
 */
class ModelUserCompanyInformation extends Model
{
    use Properties;
    use Validation;

    protected function init()
    {
        $this->setSource('user_company_information');
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