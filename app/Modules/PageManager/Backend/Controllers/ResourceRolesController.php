<?php
namespace Modules\PageManager\Backend\Controllers;


use Lib\Common\Arrays;
use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\PageManager\Backend\Models\ModelCategoryResources;
use Modules\PageManager\Backend\Models\ModelResources;
use Modules\System\PageManager\Models\PageRoleMap\ModelPageRoleMap;

class ResourceRolesController extends AdminController
{
    public function indexAction()
    {
        $response = [];
        $response['title'] = 'جدول تعیین نقش برای هر منبعی که به حالت انتخاب در آمده است.';

        try
        {
            $data = $this->filterAndValidateData();

            if (isset($data['resource_id']) && is_numeric($data['resource_id']))
            {
                $result = ModelPageRoleMap::getRolesForResource($data['resource_id']);
                $response['recordsTotal'] = count($result);

                $response['recordsFiltered'] = count($result);
                $response['data'] = $result;
            }
            else
            {
                $response['data'] = [];
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

    public function treeFlatAction()
    {
        $result = Arrays::treeFlat(
            ModelCategoryResources::find([
                'order' => 'position, created',
            ])->toArray()
        );

        $row = [];

        foreach ($result as $item)
        {
            $row[] = array_merge(
                $item,
                [
                    'html' => '<span style="direction: rtl; text-align: right">'.str_repeat('&nbsp;', $item['level']*2) . $item['title'].'</span>'
                ]
            );
        }

        $this->response->setJsonContent([
            'data' => $row
        ]);
        $this->response->send();
        die;
    }

    private function filterAndValidateData()
    {
        if (!$this->isValidDraw())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        if (!$this->isValidColumns())
        {
            throw new Exception(T::_('access_denied'), 400);
        }

        return $this->request->getQuery();
    }

    private function isValidDraw(): bool
    {
        if ($this->request->getQuery('draw') && is_numeric($this->request->getQuery('draw')))
            return true;

        return false;
    }

    private function isValidColumns(): bool
    {
        if ($this->request->getQuery('columns') && is_array($this->request->getQuery('columns')))
            return true;

        return false;
    }
}