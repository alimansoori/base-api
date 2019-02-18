<?php
namespace Modules\System\Permission\Editors;


use Lib\DTE\Editor;
use Modules\System\Permission\Editors\RoleResources\Fields;
use Modules\System\Permission\Models\ModelRoleResourceMap;
use Modules\System\Permission\Models\ModelRoles;
use Phalcon\Mvc\Model\Transaction\Failed;

class RoleResourcesEditor extends Editor
{
    use Fields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldResId();
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
        $role_id = $this->dispatcher->getParam('role_id');
        if(!ModelRoles::isRole($role_id)) return;
        try
        {
            $module = null;
            foreach($this->getDataAfterValidate() as $id => $data)
            {
                if(!(isset($data['id']) && isset($data['status'])) && !(is_numeric($data['id']) && is_bool($data['status'])))
                {
                    return;
                }

                $resource_id = $data['id'];
                $status = $data['status'] == 1 ? 'allow' : 'deny';

                $roleRes = ModelRoleResourceMap::findFirst([
                    'conditions' => 'role_id=?1 AND resource_id=?2',
                    'bind' => [
                        1 => $role_id,
                        2 => $resource_id
                    ]
                ]);

                if(!$roleRes)
                {
                    $roleRes = new ModelRoleResourceMap();
                    $roleRes->setRoleId($role_id);
                    $roleRes->setResourceId($resource_id);
                }

                $roleRes->setTransaction($this->transactions);

                $roleRes->setStatus($status);

                if(!$roleRes->save())
                {
                    $this->appendMessages($roleRes->getMessages());
                    $roleRes->getTransaction()->rollback('does not edit');
                    continue;
                }

                $this->addData(ModelRoleResourceMap::getUpdateDataForTable($roleRes->getResource(), $role_id));
            }

            $this->transactions->commit();
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