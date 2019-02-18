<?php
namespace Modules\PageManager\Backend\Controllers;


use Lib\Common\Arrays;
use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\PageManager\Backend\Models\ModelCategoryResources;
use Modules\PageManager\Backend\Models\ModelResources;

class ResourcesController extends AdminController
{
    public function indexAction()
    {
        $response = [];
        $response['title'] = 'جدول منابع پرتال';

        try
        {
            $data = $this->filterAndValidateData();

            if (isset($data['category_id']) && is_numeric($data['category_id']))
            {
                /** @var ModelCategoryResources $category */
                $category = ModelCategoryResources::findFirst($data['category_id']);
                $regexp = $data['category_id'];
                if ($category)
                {
                    $childs = $category->getChildList();
                    if (!empty($childs))
                        $regexp = $data['category_id'].'|'. implode('|', $childs);
                }


                $builder = $this->modelsManager->createBuilder();
                $builder->from(ModelResources::class);
                $builder->where("REGEXP(category_id, '^($regexp)$')");
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

                $response['recordsFiltered'] = count($result);
                $response['data'] = Arrays::treeFlat(
                    $result->toArray()
                );
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