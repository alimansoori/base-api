<?php
namespace Modules\System\Menu\DTE\Editors;


use Lib\DTE\Editor;
use Modules\System\Menu\DTE\Editors\EditorAdminMenu\Fields;
use Modules\System\Menu\Models\AdminMenu\ModelAdminMenu;
use Phalcon\Mvc\Model\Transaction\Failed;

class EditorAdminMenu extends Editor
{
    use Fields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldTitle();
        $this->fieldRoles();
        $this->fieldCategory();
        $this->fieldParentId();
        $this->fieldLink();
        $this->fieldIcon();
        $this->fieldPosition();
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    public function createAction()
    {
        try
        {
            foreach ($this->getDataAfterValidate() as $data)
            {
                $model = new ModelAdminMenu();
                $model->setTransaction($this->transactions);

                $model->setFieldsByData($data);

                if (!$model->save())
                {
                    $this->transactions->rollback(null, $model);
                }


                $model->afterSaveTitle($data);

                $model->afterSaveRoles($data);

                $model->sortByPosition([
                    'parent_id'
                ]);

                break;
            }

            $this->transactions->commit();
        }
        catch (Failed $exception)
        {
            if ($exception->getRecord()) {
                $this->appendMessages($exception->getRecord()->getMessages());
            } else {
                $this->appendMessage($exception->getMessage());
            }

            return false;
        }

        $this->reload = true;
    }

    public function editAction()
    {
        try {
            foreach ($this->getDataAfterValidate() as $id => $data)
            {
                /** @var ModelAdminMenu $model */
                $model = ModelAdminMenu::findFirst($id);
                $model->setTransaction($this->transactions);

                $model->setFieldsByData($data);

                if (!$model->save())
                {
                    $this->transactions->rollback(null, $model);
                }

                $model->afterSaveTitle($data);

                $model->afterSaveRoles($data);

                $model->sortByPosition([
                    'parent_id'
                ]);
            }

            $this->transactions->commit();
        } catch (Failed $exception) {
            if ($exception->getRecord())
                $this->appendMessage($exception->getRecord()->getMessages());
            else
                $this->appendMessage($exception->getMessage());

            return false;
        }

        $this->reload = true;
    }

    public function removeAction()
    {
        try
        {
            foreach ($this->getDataAfterValidate() as $id => $data)
            {
                /** @var ModelAdminMenu $model */
                $model = ModelAdminMenu::findFirst($id);
                $model->setTransaction($this->transactions);


                if (!$model->delete())
                {
                    $this->transactions->rollback(null, $model);
                }

                $model->sortByPosition([
                    'parent_id'
                ]);
            }

            $this->transactions->commit();
        }
        catch (Failed $exception)
        {
            if ($exception->getRecord())
                $this->appendMessages($exception->getRecord()->getMessages());
            else
                $this->appendMessage($exception->getMessage());

            return false;
        }

        $this->reload = true;
    }
}