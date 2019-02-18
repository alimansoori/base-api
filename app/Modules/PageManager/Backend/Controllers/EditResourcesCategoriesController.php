<?php
namespace Modules\PageManager\Backend\Controllers;


use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\PageManager\Backend\Models\ModelCategoryResources;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\ModelInterface;

class EditResourcesCategoriesController extends AdminController
{
    public function indexAction()
    {
        $model = null;
        $response = [];
        try
        {
            $data = $this->filterAndValidateData();

            foreach ($data as $rowId => $datum)
            {
                if (!is_numeric($rowId))
                {
                    throw new Exception(T::_('access_denied'), 401);
                }

                /** @var ModelCategoryResources $model */
                $model = ModelCategoryResources::findFirst($rowId);

                if (!$model)
                {
                    throw new Exception('این فیلد وجود نداره که بخاد ویرایش بشه');
                }

                $model->setTransaction($this->transactions);


                $model->assign(
                    $datum,
                    null,
                    [
                        'title',
                        'parent_id',
                        'position',
                        'description'
                    ]
                );

                if (!$model->save())
                {
                    $this->transactions->rollback(null, $model);
                }
            }

            if ($model instanceof ModelInterface)
            {
                $model->sortByPosition([
                    'parent_id'
                ]);
            }

            $response['reload'] = true;

            $this->transactions->commit();
        }
        catch (Failed $exception)
        {
            $this->response->setStatusCode(406);

            if ($exception->getRecord())
            {
                foreach ($exception->getRecord()->getMessages() as $message)
                {
                    if ($message->getField() == 'title' || $message->getField() == 'description' || $message->getField() == 'position')
                    {
                        $response['fieldErrors'][] = [
                            'name' => $message->getField(),
                            'status' => $message->getMessage()
                        ];
                    }
                    else
                    {
                        $response['error'] = $message->getMessage();
                    }
                }
            }
            else
            {
                $response['error'] = $exception->getMessage();
            }
        }
        catch (Exception $exception)
        {
            if ($exception->getCode())
                $this->response->setStatusCode($exception->getCode());

            $response['error'] = $exception->getMessage();
        }

        $this->response->setJsonContent($response);
        $this->response->send();
        die;
    }

    private function filterAndValidateData()
    {
        if (!$this->isValidAction())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        //        if (!$this->isValidName())
        //        {
        //            throw new Exception(T::_('access_denied2'), 400);
        //        }

        if (!$this->isValidData())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        return $this->request->getPut('data');
    }

    private function isValidAction(): bool
    {
        if ($this->request->getPut('action') == 'edit')
            return true;

        return false;
    }

    private function isValidName(): bool
    {
        if ($this->request->getPut('name') == $this->tableCategory->process(false)->getEditor('category_editor')->getName())
            return true;

        return false;
    }

    private function isValidData(): bool
    {
        if ($this->request->getPut('data') && is_iterable($this->request->getPut('data')))
            return true;

        return false;
    }
}