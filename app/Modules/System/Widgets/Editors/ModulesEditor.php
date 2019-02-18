<?php
namespace Modules\System\Widgets\Editors;


use Lib\DTE\Editor;
use Modules\System\Widgets\Editors\Modules\Fields;
use Modules\System\Widgets\Models\ModelModules;
use Phalcon\Mvc\Model\Transaction\Failed;

class ModulesEditor extends Editor
{
    use Fields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldName();
        $this->fieldTitle();
        $this->fieldDescription();
        $this->fieldPosition();
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    public function createAction()
    {
        $module = null;
        foreach($this->getDataAfterValidate() as $data)
        {
            try
            {
                $module = new ModelModules();
                $module->setTransaction($this->transactions);
                $module->setFieldsByData($data);

                if(!$module->save())
                {
                    $this->appendMessages($module->getMessages());
                    $module->getTransaction()->rollback('dont save module in editor createAction');
                }

                $module->getTransaction()->commit();

            }
            catch(Failed $exception)
            {
//                $this->appendMessage(new Message($exception->getMessage()));
                return;
            }

            $this->addData(ModelModules::getModuleForTable($module));
        }

        if($module instanceof ModelModules)
            $module->sortByPosition();
    }

    public function editAction()
    {
        try
        {
            $module = null;
            foreach($this->getDataAfterValidate() as $id => $data)
            {
                /** @var ModelModules $module */
                $module = ModelModules::findFirst($id);
                if(!$module)
                    continue;

                $module->setTransaction($this->transactions);

                $module->setFieldsByData($data);

                if(!$module->update())
                {
                     $this->appendMessages($module->getMessages());
                    $module->getTransaction()->rollback('does not edit in editActionEditor editor name = '. $module->getName());
                    continue;
                }

                $this->addData(ModelModules::getModuleForTable($module));
            }

            if($module instanceof ModelModules)
                $module->sortByPosition();

            $this->transactions->commit();
        }
        catch(Failed $exception)
        {
//            $this->appendMessage(new Message($exception->getMessage()));
        }
    }

    public function removeAction()
    {
        try
        {
            $module = null;
            foreach($this->getDataAfterValidate() as $moduleId=>$value)
            {
                /** @var ModelModules $module */
                $module = ModelModules::findFirst($moduleId);

                if(!$module)
                {
                    continue;
                }

                $module->setTransaction($this->transactions);

                if(!$module->delete())
                {
                     $this->appendMessages($module->getMessages());
                    $module->getTransaction()->rollback('does not delete '. $module->getName());
                }

            }

            if($module instanceof ModelModules)
                $module->sortByPosition();

            $this->transactions->commit();
        }
        catch(Failed $exception)
        {
//            $this->appendMessage(new Message($exception->getMessage()));
        }
    }
}