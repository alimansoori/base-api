<?php
namespace Modules\PageManager\Backend\Controllers;


use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\PageManager\Backend\Models\ModelCategoryResources;
use Modules\System\PageManager\Models\PageRoleMap\ModelPageRoleMap;
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\ModelInterface;

class EditResourceRolesController extends AdminController
{
    public function indexAction()
    {
        $model = null;
        $response = [];
        try
        {
            $putData = $this->request->getPut();
            $data = $this->filterAndValidateData();

            $resourceId = $putData['resource_id'];

            foreach($data as $roleId => $datum)
            {
                if(!(isset($datum['status'])) && !(is_numeric($roleId) && is_bool($datum['status'])))
                {
                    return;
                }

                $status = $datum['status'];

                $model = ModelPageRoleMap::findFirst([
                    'conditions' => 'page_id=?1 AND role_id=?2',
                    'bind' => [
                        1 => $resourceId,
                        2 => $roleId
                    ]
                ]);

                if ($model && !$status)
                {
                    if(!$model->delete())
                    {
                        throw new Exception('حذف نشد');
                    }
                }

                if(!$model && $status == 1)
                {
                    $model = new ModelPageRoleMap();
                    $model->setPageId($resourceId);
                    $model->setRoleId($roleId);

                    if(!$model->create())
                    {
                        throw new Exception('آپدیت نشد');
                    }
                }

                break;
            }

            $response['data'][] = ModelPageRoleMap::getUpdateDataForTable($model->getRole(), $resourceId);
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