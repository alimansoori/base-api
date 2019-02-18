<?php
namespace Modules\System\Menu\DTE\Editors;


use Lib\DTE\Editor;
use Modules\System\Menu\DTE\Editors\EditorAdminMenuCategories\Fields;
use Modules\System\Menu\Models\AdminMenuCategory\ModelAdminMenuCategory;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\ModelInterface;

class EditorAdminMenuCategories extends Editor
{
    use Fields;

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFields()
    {
        $this->fieldTitle();
        $this->fieldPosition();
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }

    public function createAction()
    {
        try {
            foreach ($this->getDataAfterValidate() as $data)
            {
                $cat = new ModelAdminMenuCategory();

                $cat->setTransaction($this->transactions);
                $cat->setFieldsByData($data);

                if (!$cat->save())
                {
                    $this->appendMessages($cat->getMessages());
                    $this->transactions->rollback("rollback dont save manage");
                }

                if (isset($data['title']))
                {
                    $cat->afterSaveTitle($data['title']);
                }

                $cat->sortByPosition();
                $this->addData(
                    ModelAdminMenuCategory::getDataTable($cat)
                );

                break;
            }

            $this->transactions->commit();

        } catch (Failed $exception) {
            $this->appendMessage($exception->getMessage());
            return;
        }
    }

    public function editAction()
    {
        try {
            $cat = null;

            foreach ($this->getDataAfterValidate() as $id=>$data)
            {
                /** @var ModelAdminMenuCategory $cat */
                $cat = ModelAdminMenuCategory::findFirst($id);

                if (!$cat)
                {
                    $this->appendMessage('manage does not exist');
                    return false;
                }

                $cat->setTransaction($this->transactions);
                $cat->setFieldsByData($data);

                if (!$cat->save())
                {
                    $this->appendMessages($cat->getMessages());
                    $this->transactions->rollback("rollback dont save manage");
                }

                if (isset($data['title']))
                {
                    $cat->afterSaveTitle($data['title']);
                }

                $this->addData(
                    ModelAdminMenuCategory::getDataTable($cat)
                );
            }

            if ($cat instanceof ModelInterface)
                $cat->sortByPosition();

            $this->transactions->commit();

        } catch (Failed $exception) {
            $this->appendMessage($exception->getMessage());
            return;
        }
    }

    public function removeAction()
    {
        try
        {
            $cat = null;
            foreach($this->getDataAfterValidate() as $moduleId=>$value)
            {
                /** @var ModelAdminMenuCategory $cat */
                $cat = ModelAdminMenuCategory::findFirst($moduleId);

                if(!$cat)
                    continue;

                $cat->setTransaction($this->transactions);

                if(!$cat->delete())
                {
                    $this->appendMessages($cat->getMessages());
                    $cat->getTransaction()->rollback('does not delete ');
                }
            }

            if($cat instanceof ModelInterface)
                $cat->sortByPosition();

            $this->transactions->commit();
        }
        catch(Failed $exception)
        {
        }
    }
}