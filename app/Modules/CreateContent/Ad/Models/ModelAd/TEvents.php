<?php
namespace Modules\CreateContent\Ad\Models\ModelAd;

use Lib\Authenticates\Auth;

/**
 * @property Auth $auth
 */
trait TEvents
{
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();

        if (!$this->getUserId() && $this->auth->isLoggedIn())
        {
            $this->setUserId($this->auth->getUserId());
        }
    }
}