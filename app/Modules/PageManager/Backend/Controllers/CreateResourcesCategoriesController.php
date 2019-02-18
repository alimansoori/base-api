<?php
namespace Modules\PageManager\Backend\Controllers;


use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\PageManager\Backend\Models\ModelCategoryResources;
use Phalcon\Mvc\Model\Transaction;

class CreateResourcesCategoriesController extends AdminController
{
    public function indexAction()
    {
        $response = [];
        try
        {
            $data = $this->filterAndValidateData();

            /** @var ModelCategoryResources $model */
            $model = new ModelCategoryResources();
            $model->setTransaction($this->transactions);

            $model->assign(
                $data,
                null,
                [
                    'title',
                    'parent_id',
                    'description',
                    'position'
                ]
            );

            if (!$model->save())
            {
                $this->transactions->rollback(null, $model);
            }

            $model->sortByPosition([
                'parent_id'
            ]);

            $response['reload'] = true;
            if (is_numeric($data['parent_id']))
            {
                /** @var ModelCategoryResources $category */
                $category = ModelCategoryResources::findFirst($data[ 'parent_id']);
                if ($category)
                {
                    $response['search']['field'] = 'parent_id';
                    $response['search']['regex'] = '^(0|'.$data['parent_id'].')$';

                    if (!empty($category->getParentList()))
                    {
                        $response['search']['regex'] = "^(0|".$data['parent_id'].'|'.implode('|', $category->getParentList()).")$";
                    }
                }
            }
            $this->transactions->commit();
        }
        catch (Transaction\Failed $exception)
        {
            $this->response->setStatusCode(406);

            if ($exception->getRecord())
            {
                foreach ($exception->getRecord()->getMessages() as $message)
                {
                    $response['fieldErrors'][] = [
                        'name' => $message->getField(),
                        'status' => $message->getMessage()
                    ];
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

        if (!$this->isValidData())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        $data = $this->request->getPost('data');

        if (!is_array(reset($data)))
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        return reset($data);
    }

    private function isValidAction(): bool
    {
        if ($this->request->getPost('action') == 'create')
            return true;

        return false;
    }

    private function isValidData(): bool
    {
        if ($this->request->getPost('data') && is_iterable($this->request->getPost('data')))
            return true;

        return false;
    }
}