<?php
namespace Modules\PageManager\Backend\Controllers;


use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\PageManager\Backend\Models\ModelCategoryResources;
use Modules\PageManager\Backend\Models\ModelResources;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\ModelInterface;

class EditResourcesController extends AdminController
{
    public function indexAction()
    {
        $model = null;
        $response = [];
        try
        {
            $data = $this->filterAndValidateData();

            foreach ($data as $resourceId => $datum)
            {
                $categoryId1 = $this->request->getPost('category_id');
                $data = $this->filterAndValidateData();

                $categoryId2 = null;
                if ($datum['category_id'])
                {
                    $categoryId2 = $datum['category_id'];
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
                $model = ModelResources::findFirst($resourceId);
                $model->setTransaction($this->transactions);
                $model->setCategoryId($categoryId);

                $model->assign(
                    $datum,
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
                break;
            }

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