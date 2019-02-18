<?php

namespace Modules\PageManager\Backend\Controllers;


use Lib\Common\Arrays;
use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Translate\T;
use Modules\PageManager\Backend\Models\ModelCategoryResources;
use Modules\PageManager\Backend\Models\ModelResources;
use Modules\System\PageManager\Models\PageRoleMap\ModelPageRoleMap;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;
use Modules\System\Widgets\Models\ModelPageWidgetPlaceMap;
use Modules\System\Widgets\Models\ModelWidgetViewDesktop;
use Modules\System\Widgets\Models\ModelWidgetViewMobile;
use Modules\System\Widgets\Models\ModelWidgetViewTablet;
use Modules\System\Widgets\Models\WidgetPlaces\ModelWidgetPlaces;
use Phalcon\Mvc\Model\Transaction\Failed;

class ResourceDesignController extends AdminController
{
    public function indexAction()
    {
        $response = [];
        $response[ 'title' ] = '';

        try {
//            $data = $this->filterAndValidateData();

            $data = $this->request->getQuery();

            if (isset($data[ 'place' ])) {
                /** @var ModelWidgetPlaces $place */
                $place = ModelWidgetPlaces::findFirstByValue($data[ 'place' ]);

                if (!$place) {
                    throw new Exception('');
                }

                if (
                !(
                    isset($data[ 'resource_id' ]) && is_numeric($data[ 'resource_id' ]) &&
                    isset($data[ 'device' ]) && ($data[ 'device' ] == 'desktop' || $data[ 'device' ] == 'tablet' || $data[ 'device' ] == 'mobile')
                )
                ) {
                    throw new Exception('');
                }

                $result = ModelPageWidgetPlaceMap::getTableInformation($data['device'], $data['resource_id'],$place->getId());
                $response[ 'recordsTotal' ] = count($result);

                $response[ 'recordsFiltered' ] = count($result);
                $response[ 'data' ] = $result;
            }
        } catch (Exception $exception) {
            if ($exception->getCode()) {
                $this->response->setStatusCode($exception->getCode());
            }

            //            $response['error'] = $exception->getMessage();
            $response[ 'data' ] = [];
        }

        $this->response->setJsonContent($response);
        $this->response->send();
        die;
    }

    public function deleteAction()
    {
        $response = [];
        $response[ 'title' ] = '';

        try {
            $data = $this->request->getQuery();

            if (isset($data[ 'place' ])) {
                /** @var ModelWidgetPlaces $place */
                $place = ModelWidgetPlaces::findFirstByValue($data[ 'place' ]);

                if (!$place) {
                    throw new Exception('');
                }

                if
                (
                    !(
                        isset($data[ 'resource_id' ]) && is_numeric($data[ 'resource_id' ]) &&
                        isset($data[ 'device' ]) && ($data[ 'device' ] == 'desktop' || $data[ 'device' ] == 'tablet' || $data[ 'device' ] == 'mobile')
                    )
                )
                {
                    throw new Exception('');
                }

                foreach ($data['data'] as $rowIndex=>$value)
                {
                    $findWidgetViewsByPagePlaceIdANDRow = $this->findWidgetViewsByPagePlaceIdANDRow($this->getPageWidgetPlaceMap($data['resource_id'], $place->getId())->getId(), $rowIndex, $data['device']);

                    if ($findWidgetViewsByPagePlaceIdANDRow === false) {
                        break;
                    }

                    foreach ($findWidgetViewsByPagePlaceIdANDRow as $widgetView) {
                        $widgetView->setTransaction($this->transactions);

                        if (!$widgetView->delete()) {
                            $this->transactions->rollback('rollback delete row');
                        }
                    }

                    $this->transactions->commit();
                    break;
                }

            }
        } catch (Exception $exception) {
            $response['fieldErrors'][] = [
                'name' => '',
                'status' => $exception->getMessage()
            ];
        } catch (Failed $exception) {
            $response['fieldErrors'][] = [
                'name' => '',
                'status' => $exception->getMessage()
            ];
        }

        $this->response->setJsonContent($response);
        $this->response->send();
        die;
    }

    public function editCreateAction()
    {
        $response = [];
        try {
            $data = $this->request->getPut();

            if (isset($data[ 'place' ])) {
                /** @var ModelWidgetPlaces $place */
                $place = ModelWidgetPlaces::findFirstByValue($data[ 'place' ]);

                if (!$place) {
                    throw new Exception(T::_('access_denied'));
                }

                if (
                !(
                    isset($data[ 'resource_id' ]) && is_numeric($data[ 'resource_id' ]) &&
                    isset($data[ 'device' ]) && ($data[ 'device' ] == 'desktop' || $data[ 'device' ] == 'tablet' || $data[ 'device' ] == 'mobile')
                )
                ) {
                    throw new Exception(T::_('access_denied'));
                }

                $device = $data['device'];
                $resourceId = $data['resource_id'];

                foreach ($data['data'] as $rowIndex=>$newData)
                {
                    $widgetView = null;

                    if ($device == 'desktop')
                    {
                        $this->saveData($newData, ModelWidgetViewDesktop::class, $this->getPageWidgetPlaceMap($resourceId, $place->getId()), $rowIndex);
                    }
                    elseif ($device == 'tablet')
                    {
                        $this->saveData($newData, ModelWidgetViewTablet::class, $this->getPageWidgetPlaceMap($resourceId, $place->getId()), $rowIndex);
                    }
                    elseif ($device == 'mobile')
                    {
                        $this->saveData($newData, ModelWidgetViewMobile::class, $this->getPageWidgetPlaceMap($resourceId, $place->getId()), $rowIndex);
                    }

                    $rowData = [];
                    if ($device == 'desktop')
                    {
                        /** @var ModelWidgetViewDesktop[] $pageWidgetViews */
                        $pageWidgetViews = ModelWidgetViewDesktop::find([
                            'conditions' => 'page_place_id=?1 AND row=?2',
                            'order' => 'row',
                            'bind' => [
                                1 => $this->getPageWidgetPlaceMap($resourceId, $place->getId())->getId(),
                                2 => $rowIndex
                            ]
                        ]);

                        $rowData['DT_RowId'] = $rowIndex;

                        foreach ($pageWidgetViews as $pageWidgetView)
                        {
                            $rowData[$pageWidgetView->getColumn()][ 'display'] = (is_null($pageWidgetView->getWidgetId())) ? null : $pageWidgetView->getWidgetInstance()->getWidget()->getName();
                            $rowData[$pageWidgetView->getColumn()][ '_'] = $pageWidgetView->getWidgetId();
                        }
                    }
                    elseif ($device == 'tablet')
                    {
                        /** @var ModelWidgetViewTablet[] $pageWidgetViews */
                        $pageWidgetViews = ModelWidgetViewTablet::find([
                            'conditions' => 'page_place_id=?1 AND row=?2',
                            'order' => 'row',
                            'bind' => [
                                1 => $this->getPageWidgetPlaceMap($resourceId, $place->getId())->getId(),
                                2 => $rowIndex
                            ]
                        ]);

                        $rowData['DT_RowId'] = $rowIndex;

                        foreach ($pageWidgetViews as $pageWidgetView)
                        {
                            $rowData[$pageWidgetView->getColumn()][ 'display'] = (is_null($pageWidgetView->getWidgetId())) ? null : $pageWidgetView->getWidgetInstance()->getWidget()->getName();
                            $rowData[$pageWidgetView->getColumn()][ '_'] = $pageWidgetView->getWidgetId();
                        }
                    }
                    elseif ($device == 'mobile')
                    {
                        /** @var ModelWidgetViewMobile[] $pageWidgetViews */
                        $pageWidgetViews = ModelWidgetViewMobile::find([
                            'conditions' => 'page_place_id=?1 AND row=?2',
                            'order' => 'row',
                            'bind' => [
                                1 => $this->getPageWidgetPlaceMap($resourceId, $place->getId())->getId(),
                                2 => $rowIndex
                            ]
                        ]);

                        $rowData['DT_RowId'] = $rowIndex;

                        foreach ($pageWidgetViews as $pageWidgetView)
                        {
                            $rowData[$pageWidgetView->getColumn()][ 'display'] = (is_null($pageWidgetView->getWidgetId())) ? null : $pageWidgetView->getWidgetInstance()->getWidget()->getName();
                            $rowData[$pageWidgetView->getColumn()][ '_'] = $pageWidgetView->getWidgetId();
                        }
                    }

                    $response['data'][] = $rowData;
                }
            }
        } catch (Exception $exception) {
            $response['fieldErrors'][] = [
                'name' => '',
                'status' => $exception->getMessage()
            ];
        } catch (Failed $exception) {
            $response['fieldErrors'][] = [
                'name' => '',
                'status' => $exception->getMessage()
            ];
        }

        $this->response->setJsonContent($response);
        $this->response->send();
        die;
    }

    public function widgetOptionSelectAction()
    {
        $row = [];
        /** @var ModelWidgetInstance[] $opts */
        $opts = ModelWidgetInstance::find();

        $row[] = [
            'label' => 'هیچکدام',
            'value' => 'null'
        ];

        foreach ($opts as $opt)
        {
            $row[] = [
                'label' => $opt->getWidget()->getName(),
                'value' => $opt->getId()
            ];
        }

        $this->response->setJsonContent($row);
        $this->response->send();
        die;
    }

    private function filterAndValidateData()
    {
        if (!$this->isValidDraw()) {
            throw new Exception(T::_('access_denied'), 400);
        }

        if (!$this->isValidColumns()) {
            throw new Exception(T::_('access_denied'), 400);
        }

        return $this->request->getQuery();
    }

    private function isValidDraw(): bool
    {
        if ($this->request->getQuery('draw') && is_numeric($this->request->getQuery('draw'))) {
            return true;
        }

        return false;
    }

    private function isValidColumns(): bool
    {
        if ($this->request->getQuery('columns') && is_array($this->request->getQuery('columns'))) {
            return true;
        }

        return false;
    }

    /**
     * @param $resourceId
     * @param $placeId
     * @return ModelPageWidgetPlaceMap
     */
    private function getPageWidgetPlaceMap($resourceId, $placeId)
    {
        /** @var ModelPageWidgetPlaceMap $pageWidgetPlaceMap */
        $pageWidgetPlaceMap = ModelPageWidgetPlaceMap::findFirst([
            'conditions' => 'page_id=:p_id: AND place_id=:place_id:',
            'bind' => [
                'p_id' => $resourceId,
                'place_id' => $placeId
            ]
        ]);

        if (!$pageWidgetPlaceMap)
        {
            $pageWidgetPlaceMap = new ModelPageWidgetPlaceMap();
            $pageWidgetPlaceMap->setPageId($resourceId);
            $pageWidgetPlaceMap->setPlaceId($placeId);
            $pageWidgetPlaceMap->save();
        }

        return $pageWidgetPlaceMap;
    }

    private function saveData($data = [], $modelClass, $pageWidgetPlaceMap, $row)
    {
        $newData = $data;

        $widgetViewExist = $modelClass::findFirst([
            'conditions' => 'page_place_id=:p_id: AND row=:row:',
            'bind' => [
                'p_id' => $pageWidgetPlaceMap->getId(),
                'row' => $row
            ]
        ]);
        if ($widgetViewExist)
        {
            $newData = [];
            foreach ($data as $k=>$v)
            {
                $newData[$k] = $v;
            }
        }

        foreach ($newData as $column => $widgetId)
        {
            /** @var ModelWidgetViewMobile|ModelWidgetViewDesktop|ModelWidgetViewTablet $widgetView */
            $widgetView = $modelClass::findFirst([
                'conditions' => 'page_place_id=:p_id: AND row=:row: AND column=:column:',
                'bind' => [
                    'p_id' => $pageWidgetPlaceMap->getId(),
                    'row' => $row,
                    'column' => $column
                ]
            ]);

            if (!$widgetView)
            {
                $widgetView = new $modelClass();
                $widgetView->setRow($row);
                $widgetView->setColumn($column);
                $widgetView->setPagePlaceId($pageWidgetPlaceMap->getId());
            }
            $widgetView->setTransaction($this->transactions);

            $widgetView->setWidgetId($widgetId);

            if (!$widgetId || $widgetId == 'null') {
                $widgetView->setWidgetId(null);
            }

            if(!$widgetView->save())
            {
                $this->transactions->rollback('do not save');
            }
        }
        $this->transactions->commit();
    }

    /**
     * @param $pagePlaceId
     * @param $row
     * @return bool|ModelWidgetViewTablet[]|ModelWidgetViewDesktop[]|ModelWidgetViewMobile[]
     */
    private function findWidgetViewsByPagePlaceIdANDRow($pagePlaceId, $row, $device)
    {
        /** @var ModelWidgetViewTablet|ModelWidgetViewDesktop|ModelWidgetViewMobile $classModel */
        $classModel = null;

        if ($device == 'mobile')
            $classModel = ModelWidgetViewMobile::class;
        elseif ($device == 'desktop')
            $classModel = ModelWidgetViewDesktop::class;
        elseif ($device == 'tablet')
            $classModel = ModelWidgetViewTablet::class;
        else
            return false;

        return $classModel::find([
            'conditions' => 'page_place_id=:page_place_id: AND row=:row:',
            'order' => 'row',
            'bind' => [
                'page_place_id' => $pagePlaceId,
                'row' => $row
            ]
        ]);

    }
}