<?php
namespace Modules\System\Permission\Editors;


use Lib\DTE\Editor;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Permission\Editors\Roles\Fields;
use Modules\System\Permission\Models\ModelRoles;

class RolesEditor extends Editor
{
    use Fields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldName();
        $this->fieldRelatedModule();
        $this->fieldTitle();
        $this->fieldDescription();
        $this->fieldStatus();
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    public function createAction()
    {
        foreach($this->getDataAfterValidate() as $id => $data)
        {
            /** @var ModelRoles $role */
            $role = new ModelRoles();
            $role->setTransaction($this->transactions);

            if(isset($data['name']))
                $role->setName($data['name']);
            if(isset($data['title']))
                $role->setTitle($data['title']);
            if(isset($data['module_id']))
                $role->setModuleId($data['module_id']);
            if(isset($data['status']))
                $role->setStatus($data['status']);

            $role->setLanguageIso(ModelLanguage::getCurrentLanguage());

            if(!$role->save())
            {
                $this->appendMessages($role->getMessages());
                $role->getTransaction()->rollback('rollback');
                return;
            }

            $role->getTransaction()->commit();

            $this->addData(
                ModelRoles::getRoleForTable($role)
            );
        }
    }

    public function editAction()
    {
        foreach($this->getDataAfterValidate() as $id => $data)
        {
            /** @var ModelRoles $role */
            $role = ModelRoles::findFirst($id);

            if(!$role)
            {
                $this->setError(T::_('role_not_exist'));
                continue;
            }

            $role->setFieldsByData($data);

            if(!$role->update())
            {
                $this->appendMessages($role->getMessages());
                return;
            }

            $this->addData(
                ModelRoles::getRoleForTable($role)
            );
        }
    }

    public function removeAction()
    {
        foreach($this->getDataAfterValidate() as $pageId=>$value)
        {
            /** @var ModelRoles $role */
            $role = ModelRoles::findFirst($pageId);

            if(!$role->delete())
            {
                $this->appendMessages($role->getMessages());
                continue;
            }
        }
    }
}