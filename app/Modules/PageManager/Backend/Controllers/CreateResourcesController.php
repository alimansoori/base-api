<?php
namespace Modules\PageManager\Backend\Controllers;


use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\PageManager\Backend\Models\ModelCategoryResources;
use Modules\PageManager\Backend\Models\ModelResources;
use Phalcon\Mvc\Model\Transaction;

class CreateResourcesController extends AdminController
{
    public function indexAction()
    {
        $response = [];
        try
        {
            $categoryId1 = $this->request->getPost('category_id');
            $data = $this->filterAndValidateData();

            $categoryId2 = null;
            if ($data['category_id'])
            {
                $categoryId2 = $data['category_id'];
            }

            $categoryId = $categoryId1;
            if (is_numeric($categoryId2) && $categoryId1 !== $categoryId2)
            {
                $categoryId = $categoryId2;
            }

            $category = ModelCategoryResources::findFirst($categoryId);

            if (!$category)
            {
                throw new Exception(T::_('access_denied'));
            }

            /** @var ModelResources $model */
            $model = new ModelResources();
            $model->setTransaction($this->transactions);
            $model->setCategoryId($categoryId);

            $model->assign(
                $data,
                null,
                [
                    'type',
                    'title',
                    'title_menu',
                    'slug',
                    'route',
                    'keywords',
                    'description',
                    'content',
                    'status',
                    'position'
                ]
            );

            if (!$model->save())
            {
                $this->transactions->rollback(null, $model);
            }

            $model->sortByPosition([
                'category_id',
                'parent_id',
            ]);

            $this->transactions->commit();

        }
        catch (Transaction\Failed $exception)
        {
            $this->response->setStatusCode(406);

            if ($exception->getRecord())
            {
                foreach ($exception->getRecord()->getMessages() as $message)
                {
                    if (
                    $message->getField() == 'title' ||
                    $message->getField() == 'title_menu' ||
                    $message->getField() == 'type' ||
                    $message->getField() == 'slug' ||
                    $message->getField() == 'route' ||
                    $message->getField() == 'keywords' ||
                    $message->getField() == 'description' ||
                    $message->getField() == 'content' ||
                    $message->getField() == 'status' ||
                    $message->getField() == 'category_id' ||
                    $message->getField() == 'position'
                    )
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