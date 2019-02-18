<?php
namespace Modules\CreateContent\Ad\Controllers;

use Lib\Common\Format;
use Lib\Exception;
use Lib\Translate\T;
use Modules\CreateContent\Ad\Models\ModelAd;
use Modules\CreateContent\Ad\Models\ModelCategory;

class GetAdController extends ManageController
{
    public function indexAction()
    {
        $response = [];
        $response['title'] = 'Please set title';
        $response['recordsTotal'] = 0;
        $response['recordsFiltered'] = 0;

        try
        {
            $hierarchyId = $this->request->getQuery('hierarchy_id');

            if (!$hierarchyId || !is_numeric($hierarchyId))
            {
                $response['data'] = [];
            }
            else
            {
                $categoryId = $hierarchyId;

                /** @var ModelCategory $category */
                $category = ModelCategory::findFirst($categoryId);
                $regexp = $hierarchyId;
                if ($category)
                {
                    $childs = $category->getChildList();
                    if (!empty($childs))
                        $regexp = $hierarchyId.'|'. implode('|', $childs);
                }

                $data = $this->filterAndValidateData();

                $builder = $this->modelsManager->createBuilder();
                $builder->addFrom(ModelAd::class);
                $builder->where("REGEXP(category_id, '^($regexp)$')");
                $response['recordsTotal'] = count($builder->getQuery()->execute()->toArray());

                $builder = $this->queryDataTable(
                    $data,
//                    $this->tableAd->process(false),
                    $builder,
                    [
                        'title',
                    ]
                );

                $row = [];
                /** @var ModelAd $ad */
                foreach ($builder->getQuery()->execute() as $ad)
                {
                    $row[] = array_merge(
                        $ad->toArray(),
                        [
                            'DT_RowId' => $ad->getId(),
                            'user_id' => [
                                'display' => $ad->getUser()->getUsername(),
                                '_' => $ad->getId()
                            ],
                            'created' => [
                                'display' => $this->convertTimeToDisplay($ad->getCreated()),
                                '_' => $ad->getCreated()
                            ],
                            'modified' => [
                                'display' => $this->convertTimeToDisplay($ad->getModified()),
                                '_' => $ad->getModified()
                            ]
                        ]
                    );
                }

                $response['recordsFiltered'] = count($row);
                $response['data'] = $row;
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

    private function convertTimeToDisplay(?int $time)
    {
        $created = Format::ilya_when_to_html(
            $time,
            7
        );

        $display = '';
        if (isset($created['data']))
        {
            $display = $created['data'];
            if (isset($created['prefix']) && isset($created['suffix']))
            {
                $display = $created['prefix'] . $created['data']. $created['suffix'];
            }
        }

        return $display;
    }

}