<?php
namespace Modules\System\Widgets\Editors;


use Lib\DTE\Editor;
use Lib\Translate\T;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;
use Modules\System\Widgets\Models\ModelPageWidgetPlaceMap;
use Modules\System\Widgets\Models\ModelWidgetViewDesktop;
use Modules\System\Widgets\Models\ModelWidgetViewMobile;
use Modules\System\Widgets\Models\ModelWidgetViewTablet;
use Phalcon\Mvc\Model\Transaction\Failed;
use Lib\DTE\Editor\Fields\Type\Select2;

class PageWidgetsManagerEditor extends Editor
{
    protected $placeId;
    protected $pageId;
    protected $device;

    public function __construct($name, $device, $pageId, $placeId)
    {
        parent::__construct($name);

        $this->device = $device;
        $this->pageId = $pageId;
        $this->placeId = $placeId;
    }

    public function init()
    {
        $this->assetsManager->addInlineJsBottom( /** @lang JavaScript */
            <<<TAG
$('#{$this->getTable()->getName()} tbody').on( 'click', 'td i', function (e) {
        e.stopImmediatePropagation();
        {$this->getName()}.bubble( $(this).parent() );
    } );

TAG
);
    }

    public function initFields()
    {
        $this->field('1');
        $this->field('2');
        $this->field('3');
        $this->field('4');

        if ($this->device == 'tablet' || $this->device == 'desktop')
        {
            $this->field('5');
            $this->field('6');
            $this->field('7');
            $this->field('8');
        }

        if ($this->device == 'desktop')
        {
            $this->field('9');
            $this->field('10');
            $this->field('11');
            $this->field('12');
        }
    }

    private function field($name)
    {
        $row = [];
        /** @var ModelWidgetInstance[] $opts */
        $opts = ModelWidgetInstance::find();

        $row[] = [
            'label' => '',
            'value' => 'null'
        ];

        foreach ($opts as $opt)
        {
            $row[] = [
                'label' => $opt->getWidget()->getName(),
                'value' => $opt->getId()
            ];
        }

        $field = new Select2($name);
        $field->setData($name.'._');
//        $field->setLabel($name);
        $field->setOptions($row);
        $field->setOpts([
            'placeholder' => T::_('please_select_widget')
        ]);
        $this->addField($field);
    }

    public function initAjax()
    {
        $this->ajax->addData('device', $this->device);
        $this->ajax->addData('page_id', $this->pageId);
        $this->ajax->addData('place_id', $this->placeId);
    }

    public function createAction()
    {
    }

    public function editAction()
    {
        $device = $this->request->getPost('device');


        if (!$this->getPageWidgetPlaceMap())
        {
            $this->appendMessage('PageWidgetPlaceMap does not exist');
            return false;
        }

        $page = null;
        foreach($this->getDataAfterValidate() as $row => $data)
        {
            $widgetView = null;

            if ($device == 'desktop')
            {
                $this->saveData($data, ModelWidgetViewDesktop::class, $this->getPageWidgetPlaceMap(), $row);
            }
            elseif ($device == 'tablet')
            {
                $this->saveData($data, ModelWidgetViewTablet::class, $this->getPageWidgetPlaceMap(), $row);
            }
            elseif ($device == 'mobile')
            {
                $this->saveData($data, ModelWidgetViewMobile::class, $this->getPageWidgetPlaceMap(), $row);
            }
            else
            {
                $this->appendMessage('device incorrect');
                return false;
            }

//            $widgetView->afterSaveEditor();

            $rowData = [];
            if ($device == 'desktop')
            {
                /** @var ModelWidgetViewDesktop[] $pageWidgetViews */
                $pageWidgetViews = ModelWidgetViewDesktop::find([
                    'conditions' => 'page_place_id=?1 AND row=?2',
                    'order' => 'row',
                    'bind' => [
                        1 => $this->getPageWidgetPlaceMap()->getId(),
                        2 => $row
                    ]
                ]);

                $rowData['DT_RowId'] = $row;

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
                        1 => $this->getPageWidgetPlaceMap()->getId(),
                        2 => $row
                    ]
                ]);

                $rowData['DT_RowId'] = $row;

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
                        1 => $this->getPageWidgetPlaceMap()->getId(),
                        2 => $row
                    ]
                ]);

                $rowData['DT_RowId'] = $row;

                foreach ($pageWidgetViews as $pageWidgetView)
                {
                    $rowData[$pageWidgetView->getColumn()][ 'display'] = (is_null($pageWidgetView->getWidgetId())) ? null : $pageWidgetView->getWidgetInstance()->getWidget()->getName();
                    $rowData[$pageWidgetView->getColumn()][ '_'] = $pageWidgetView->getWidgetId();
                }
            }

            $this->addData($rowData);
        }
    }

    public function removeAction()
    {
        try {
            if (!$this->getPageWidgetPlaceMap())
            {
                $this->appendMessage('PageWidgetPlaceMap does not exist');
                return false;
            }

            foreach ($this->getDataAfterValidate() as $row=>$data)
            {
                $findWidgetViewsByPagePlaceIdANDRow = $this->findWidgetViewsByPagePlaceIdANDRow($this->getPageWidgetPlaceMap()->getId(), $row);

                if ($findWidgetViewsByPagePlaceIdANDRow === false)
                {
                    $this->appendMessage('not delete');
                    continue;
                }

                foreach ($findWidgetViewsByPagePlaceIdANDRow as $widgetView)
                {
                    $widgetView->setTransaction($this->transactions);

                    if (!$widgetView->delete())
                        $this->transactions->rollback('rollback delete row');
                }
            }

            // sort by row

            $i = 1;
            foreach ($this->findWidgetViewsByPagePlaceId($this->getPageWidgetPlaceMap()->getId()) as $sortWidgetViews)
            {
                /** @var ModelWidgetViewTablet|ModelWidgetViewDesktop|ModelWidgetViewMobile $sortWidgetView */
                foreach ($sortWidgetViews as $sortWidgetView)
                {
                    $sortWidgetView->setTransaction($this->transactions);
                    $sortWidgetView->setRow($i);
                    if (!$sortWidgetView->update())
                        $this->transactions->rollback('sort row does not update');
                }

                $i++;
            }

            $this->transactions->commit();

        } catch (Failed $exception) {
            $this->appendMessage($exception->getMessage());
            return false;
        }

        $this->redirect = $this->url->get($this->router->getRewriteUri());
    }

    private function saveData($data = [], $modelClass, $pageWidgetPlaceMap, $row)
    {
        foreach ($data as $column => $widgetId)
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
                $this->appendMessages($widgetView->getMessages());
            }
        }
        $widgetView->getTransaction()->commit();
    }

    /**
     * @return ModelPageWidgetPlaceMap
     */
    private function getPageWidgetPlaceMap()
    {
        $pageId = $this->request->getPost('page_id');
        $placeId = $this->request->getPost('place_id');

        /** @var ModelPageWidgetPlaceMap $pageWidgetPlaceMap */
        $pageWidgetPlaceMap = ModelPageWidgetPlaceMap::findFirst([
            'conditions' => 'page_id=:p_id: AND place_id=:place_id:',
            'bind' => [
                'p_id' => $pageId,
                'place_id' => $placeId
            ]
        ]);

        return $pageWidgetPlaceMap;
    }

    /**
     * @return bool|ModelWidgetViewTablet[]|ModelWidgetViewDesktop[]|ModelWidgetViewMobile[]
     */
    private function findWidgetViewsByPagePlaceIdANDRow($pagePlaceId, $row)
    {
        $device = $this->request->getPost('device');

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

    private function findWidgetViewsByPagePlaceId($pagePlaceId)
    {
        $device = $this->request->getPost('device');

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

        /** @var ModelWidgetViewTablet[]|ModelWidgetViewDesktop[]|ModelWidgetViewMobile[] $widgetViews */
        $widgetViews = $classModel::find([
            'conditions' => 'page_place_id=:page_place_id:',
            'order' => 'row',
            'bind' => [
                'page_place_id' => $pagePlaceId
            ]
        ]);

        $row = [];

        foreach ($widgetViews as $widgetView)
        {
            $row[$widgetView->getRow()][] = $widgetView;
        }

        return $row;
    }
}