<?php
namespace Modules\System\Menu\DTE\Editors;


use Lib\DTE\Editor;
use Modules\System\Menu\Forms\FormAdminMenuCategories;
use Modules\System\Menu\Forms\FormAdminMenuRoles;
use Modules\System\Menu\Models\AdminMenu\ModelAdminMenu;
use Modules\System\Menu\Models\AdminMenuCategory\ModelAdminMenuCategory;
use Phalcon\Mvc\Model\Transaction\Manager;

class EditorAdminMenuRoles extends Editor
{
    public function init()
    {
        $this->setForm(new FormAdminMenuRoles());
    }

    public function createAction()
    {
        if(empty($this->getPostData()))
            return;

        if(!$this->getForm()->isValid($this->getPostData()))
        {
            foreach($this->getForm()->getMessages() as $message)
            {
                $this->getErrorManager()->appendError(
                    $message->getField(), $message->getMessage()
                );
            }

            return;
        }

        // Valid data form
        $model = new ModelAdminMenuCategory();
        $model->setTransaction(
            (new Manager())->get()
        );
        $model->setTitle(@$this->getPostData()['title']);
        $model->setPosition(@$this->getPostData()['position']);

        if(!$model->create())
        {
            foreach($model->getMessages() as $message)
            {
                $this->getErrorManager()->appendError(
                    $message->getField(), $message->getMessage()
                );
            }
            $model->getTransaction()->rollback('admin menu dont save');
        }
        else
        {
            $this->addDataCURD(
                $model->toArray()
            );
        }

        $model->getTransaction()->commit();

    }

    public function editAction()
    {
        if(empty($this->getPostData()))
            return;


        foreach($this->getPostData() as $key => $menu)
        {
            $id = str_replace('row_', '', $key);

            if(!is_numeric($id))
                continue;

            /** @var ModelAdminMenuCategory $model */
            $model = ModelAdminMenuCategory::findFirst( $id );

            if(!$model)
                continue;

            $model->setTransaction(
                (new Manager())->get()
            );

            $model->setTitle(@$menu['title']);
            $model->setPosition(@$menu['position']);

            if(!$model->update())
            {
                foreach($model->getMessages() as $message)
                {
                    $this->getErrorManager()->appendError(
                        $message->getField(), $message->getMessage()
                    );
                }

                $model->getTransaction()->rollback('don\'t save');
            }
            else
            {
                $this->addDataCURD($model->toArray());
            }

            $model->getTransaction()->commit();
        }

    }

    public function removeAction()
    {
        if(empty($this->getPostData()))
            return;

        foreach($this->getPostData() as $key => $menu)
        {
            $id = str_replace('row_', '', $key);

            if(!is_numeric($id))
                continue;

            /** @var ModelAdminMenuCategory $model */
            $model = ModelAdminMenuCategory::findFirst($id);

            if(!$model)
                continue;

            $model->setTransaction(
                (new Manager())->get()
            );

            if(!$model->delete())
            {
                foreach($model->getMessages() as $message)
                {
                    $this->getErrorManager()->setError(
                        $message->getMessage()
                    );
                }

                $model->getTransaction()->rollback('does not delete');
            }

            $model->getTransaction()->commit();
        }
    }
}