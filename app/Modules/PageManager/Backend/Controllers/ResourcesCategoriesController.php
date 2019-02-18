<?php
namespace Modules\PageManager\Backend\Controllers;


use Lib\Common\Arrays;
use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\PageManager\Backend\Models\ModelCategoryResources;

class ResourcesCategoriesController extends AdminController
{
    public function indexAction()
    {
        $response = [];
        $response['title'] = 'جدول دسته بندی منابع پرتال';

        try
        {
            $data = $this->filterAndValidateData();

            $builder = $this->modelsManager->createBuilder();
            $builder->from(ModelCategoryResources::class);
            $builder->where('parent_id IS NULL');
            $builder->orderBy('position asc');

            $response['recordsTotal'] = count($builder->getQuery()->execute()->toArray());

            $builder = $this->queryDataTable(
                $data,
                $builder,
                [
                    'title'
                ]
            );

            $result = $builder->getQuery()->execute();

            $newData = [];
            /** @var ModelCategoryResources $modelCategoryResources */
            foreach ($result as $modelCategoryResources)
            {
                $parent['display'] = null;
                $parent['_'] = null;
                if ($modelCategoryResources->getParentId())
                {
                    $parent['display'] = $modelCategoryResources->getParent()->getTitle();
                    $parent['_'] = $modelCategoryResources->getParentId();
                }

                $newData[] = array_merge($modelCategoryResources->toArray(), ['parent' => $parent]);
            }
            $response['recordsFiltered'] = count($result);
            $response['data'] = Arrays::treeFlat(
                $newData
            );
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

        $row[] = [
            'id' => null,
            'html' => '<span>لطفا انتخاب کنید</span>'
        ];

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