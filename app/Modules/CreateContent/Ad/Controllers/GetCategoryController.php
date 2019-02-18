<?php
namespace Modules\CreateContent\Ad\Controllers;

use Lib\Common\Arrays;
use Lib\Exception;
use Lib\Translate\T;
use Modules\CreateContent\Ad\Models\ModelCategory;

class GetCategoryController extends ManageController
{
    public function indexAction()
    {
        $response = [];
        $response['title'] = 'Please set title';

        try
        {
            $data = $this->filterAndValidateData();

            $builder = $this->modelsManager->createBuilder();
            $builder->from(ModelCategory::class);
            $builder->where('parent_id IS NULL');
            $builder->orderBy('position asc');

            $response['recordsTotal'] = count($builder->getQuery()->execute()->toArray());

            $builder = $this->queryDataTable(
                $data,
//                $this->tableCategory->process(false),
                $builder,
                [
                    'title'
                ]
            );

            $response['recordsFiltered'] = count($builder->getQuery()->execute()->toArray());
            $response['data'] = Arrays::treeFlat(
                $builder->getQuery()->execute()->toArray()
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