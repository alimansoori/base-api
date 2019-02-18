<?php
namespace Modules\System\Permission\Editors;


use Lib\DTE\Editor;
use Modules\System\Permission\Editors\UserRoles\Fields;
use Modules\System\Permission\Models\ModelRoleResourceMap;
use Modules\System\Permission\Models\ModelRoles;
use Modules\System\Users\Models\ModelUsers;
use Modules\System\Users\Models\UserRoleMap\ModelUserRoleMap;
use Phalcon\Mvc\Model\Transaction\Failed;

class UserRolesEditor extends Editor
{
    use Fields;

    private $userId;
    public function __construct($name, $userId)
    {
        parent::__construct($name);
        $this->userId = $userId;
    }

    public function init()
    {
    }

    public function initFields()
    {
        $this->fieldRoleId();
        $this->fieldStatus();
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    public function createAction()
    {
    }

    public function editAction()
    {
        if(!ModelUsers::isUser($this->userId)) return;
        try
        {
            $userRole = null;
            foreach($this->getDataAfterValidate() as $id => $data)
            {
                if(!(isset($data['id']) && isset($data['status'])) && !(is_numeric($data['id']) && is_bool($data['status'])))
                {
                    return;
                }

                $roleId = $data['id'];
                $status = $data['status'] == 1 ? 'active' : 'inactive';

                $userRole = ModelUserRoleMap::findFirst([
                    'conditions' => 'user_id=?1 AND role_id=?2',
                    'bind' => [
                        1 => $this->userId,
                        2 => $roleId
                    ]
                ]);

                if(!$userRole)
                {
                    $userRole = new ModelUserRoleMap();
                    $userRole->setUserId($this->userId);
                    $userRole->setRoleId($roleId);
                }

                $userRole->setTransaction($this->transactions);

                $userRole->setStatus($status);

                if(!$userRole->update())
                {
                    $this->appendMessages($userRole->getMessages());
                    $this->transactions->rollback('does not edit');
                }

            }

            $this->transactions->commit();

            $this->addData(ModelUserRoleMap::getUpdateDataForTable($userRole->getRole(), $this->userId));
        }
        catch(Failed $exception)
        {
                $this->setError($exception->getMessage());
        }
    }

    public function removeAction()
    {
    }
}