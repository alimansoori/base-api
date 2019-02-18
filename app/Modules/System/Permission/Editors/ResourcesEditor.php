<?php
namespace Modules\System\Permission\Editors;


use Lib\DTE\Editor;
use Lib\Mvc\Model;
use Lib\Translate\T;
use Modules\System\Permission\Editors\Resources\Fields;
use Modules\System\Permission\Models\ModelResources;
use Modules\System\Permission\Models\ModelRoleResourceMap;
use Phalcon\Mvc\Model\Transaction\Failed;

class ResourcesEditor extends Editor
{
    use Fields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldTitle();
        $this->fieldModuleId();
        $this->fieldRoles();
        $this->fieldController();
        $this->fieldAction();
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    public function createAction()
    {
        $resource = null;
        foreach($this->getDataAfterValidate() as $data)
        {
            try
            {
                $resource = new ModelResources();
                $resource->setTransaction($this->transactions);
                $resource->setFieldsByData($data);

                if(!$resource->save())
                {
                    $this->appendMessages($resource->getMessages());
                    $resource->getTransaction()->rollback('dont save module in editor createAction');
                }

                if (!isset($data['roles']) || !is_array($data['roles']))
                {
                    $this->transactions->rollback(T::_('access_denied'));
                }

                $roles = $data['roles'];

                foreach ($roles as $role)
                {
                    if (!is_numeric($role))
                    {
                        continue;
                    }

                    $roleResMap = ModelRoleResourceMap::findFirst([
                        'conditions' => 'resource_id=:r: AND role_id=:role_id:',
                        'bind' => [
                            'r' => $resource->getId(),
                            'role_id' => $role
                        ]
                    ]);

                    if ($roleResMap) continue;

                    $roleResMap = new ModelRoleResourceMap();
                    $roleResMap->setTransaction($this->transactions);
                    $roleResMap->setRoleId($role);
                    $roleResMap->setResourceId($resource->getId());

                    if (!$roleResMap->save())
                    {
                        $this->transactions->rollback(T::_('access_denied'));
                    }
                }


                $this->transactions->commit();

            }
            catch(Failed $exception)
            {
                //                $this->appendMessage(new Message($exception->getMessage()));
                return;
            }

            $this->addData(ModelResources::getResourceForTable($resource));
        }
    }

    public function editAction()
    {
        try
        {
            $module = null;
            foreach($this->getDataAfterValidate() as $id => $data)
            {
                /** @var ModelResources $module */
                $module = ModelResources::findFirst($id);
                if(!$module)
                    continue;

                $module->setTransaction($this->transactions);

                $module->setFieldsByData($data);

                if(!$module->update())
                {
                    $this->appendMessages($module->getMessages());
                    $module->getTransaction()->rollback('does not edit in editActionEditor editor name = '. $module->getTitle());
                    continue;
                }

                if (!isset($data['roles']) || !is_array($data['roles']))
                {
                    $this->transactions->rollback(T::_('access_denied'));
                }

                $roles = $data['roles'];

                // حذف نقش های سابق
                /** @var ModelRoleResourceMap[] $roleResMaps */
                $roleResMaps = ModelRoleResourceMap::find([
                    'conditions' => 'resource_id=:r:',
                    'bind' => [
                        'r' => $module->getId(),
                    ]
                ]);

                foreach ($roleResMaps as $roleResMap)
                {
                    $roleResMap->setTransaction($this->transactions);
                    if (!$roleResMap->delete())
                    {
                        $this->transactions->rollback(T::_('access_denied'));
                    }
                }

                foreach ($roles as $role)
                {
                    if (!is_numeric($role))
                    {
                        continue;
                    }

                    $roleResMap = new ModelRoleResourceMap();
                    $roleResMap->setTransaction($this->transactions);
                    $roleResMap->setRoleId($role);
                    $roleResMap->setResourceId($module->getId());

                    if (!$roleResMap->save())
                    {
                        $this->transactions->rollback(T::_('access_denied'));
                    }
                }

                $this->addData(ModelResources::getResourceForTable($module));
            }

            $this->transactions->commit();
        }
        catch(Failed $exception)
        {
//                        $this->appendMessage(new Message($exception->getMessage()));
        }
    }

    public function removeAction()
    {
        try
        {
            $module = null;
            foreach($this->getDataAfterValidate() as $moduleId=>$value)
            {
                /** @var ModelResources $module */
                $module = ModelResources::findFirst($moduleId);

                if(!$module)
                {
                    continue;
                }

                $module->setTransaction($this->transactions);

                if(!$module->delete())
                {
                    $this->appendMessages($module->getMessages());
                    $module->getTransaction()->rollback('does not delete '. $module->getTitle());
                }
            }

            $this->transactions->commit();
        }
        catch(Failed $exception)
        {
//                $this->appendMessage(new Message($exception->getMessage()));
        }
    }
}