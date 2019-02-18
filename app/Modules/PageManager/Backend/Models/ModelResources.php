<?php
namespace Modules\PageManager\Backend\Models;

use Lib\Common\MobileDetect;
use Lib\Mvc\Controller;
use Lib\Mvc\Model;
use Modules\PageManager\Backend\Models\Resources\TModelPagesEvents;
use Modules\PageManager\Backend\Models\Resources\TModelPagesProperties;
use Modules\PageManager\Backend\Models\Resources\TModelPagesQueries;
use Modules\PageManager\Backend\Models\Resources\TModelPagesRelations;
use Modules\PageManager\Backend\Models\Resources\TModelPagesValidation;
use Modules\System\Native\Models\Language\ModelLanguage;
use Modules\System\Widgets\Models\ModelPageWidgetPlaceMap;
use Modules\System\Widgets\Models\ModelWidgetViewDesktop;
use Modules\System\Widgets\Models\ModelWidgetViewMobile;
use Modules\System\Widgets\Models\ModelWidgetViewTablet;
use Modules\System\Widgets\Models\WidgetPlaces\ModelWidgetPlaces;
use Morilog\Jalali\Jalalian;
use Phalcon\Di;
use Phalcon\Mvc\Router\Route;

class ModelResources extends Model
{
    use TModelPagesProperties;
    use TModelPagesRelations;
    use TModelPagesValidation;
    use TModelPagesEvents;
    use TModelPagesQueries;

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Initialize Method
     */

    protected function init()
    {
        $this->setSource('pages');
        $this->setDbRef(true);
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Public Methods
     */

    public function findRoutesBySlug()
    {
        $allRoutes = $this->getDI()->getShared('router')->getRoutes();
        //dump($allRoutes);

        $i = false;
        /** @var Route $value */
        foreach ($allRoutes as $key => $value)
        {
            if($value->getName())
            {
                $slug = explode('__',$value->getName());
                if (in_array($this->getSlug(),$slug))
                {
//                    dump($slug);
                    $i = true;
                    throw new \Exception('The slug already exists in routs, Try another one');
//                    $this->getDI()->getShared('flash')->error('The slug already exists in routs, Try another one');
                }
            }
        }

        if ($i == false)
            $this->setSlug(str_replace(' ', '-', $this->getSlug()));

    }

    public function createPageForRequest(Controller $controller)
    {
        $this->setParentId($controller->getParentIdFromGetRequest());
        $this->setTitle($controller->request->getPost('title'));
        $this->setSlug($controller->request->getPost('slug'));
        $this->setContent($controller->request->getPost('content'));
        $this->setLanguageIso($controller->request->getPost('language'));
        $this->setPosition($controller->request->getPost('position'));

        if (!$this->save())
        {
            $this->appendMessage('There is a problem in the process of storing the page !');
            return false;
        }
        else
        {
            $this->sortByPosition();
            return true;
        }
    }

    public function updatePageForRequest(Controller $controller)
    {
        $this->setTitle($controller->request->getPost('title'));
        $this->setSlug($controller->request->getPost('slug'));
        $this->setContent($controller->request->getPost('content'));
        $this->setLanguageIso($controller->request->getPost('language'));
        $this->setPosition($controller->request->getPost('position'));

        if (!$this->update())
        {
            $this->appendMessage('There is a problem in the process of storing the page !');
            return false;
        }
        else
        {
            $this->sortByPosition();
            return true;
        }
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Public static Methods
     */

    public static function findAllParentsByLang($lang = null)
    {
        if(!$lang)
        {
            return [];
        }

        $findAllParentsByLang = self::find([
            'conditions' => 'language = :lang:',
            'bind' => [
                'lang' => $lang
            ]
        ])->toArray();

        return array_column($findAllParentsByLang, 'id');
    }

    public static function positionOptions( $lang = 'en', $parent = null, $editId = null)
    {
        $modelManager = ( new self() )->getModelsManager();

        $result = $modelManager->createBuilder();

        $result->columns(['id', 'title', 'position']);
        $result->from(self::class);

        $result->where('language=:lang:', ['lang' => $lang]);

        if($parent)
            $result->andWhere('parent_id=:p:', ['p' => $parent]);
        else
            $result->andWhere('parent_id IS NULL');

        $result->orderBy('position');

        $result = $result->getQuery()->execute();

        $positionOptions = [];
        $previous = null;
        $passedself = false;
        $current = null;

        foreach($result as $value)
        {
            if($value->id == $editId)
            {
                $passedself = true;
            }

            if(!$previous)
                $positionHtml = 'First';
            else
            {
                if($passedself)
                {
                    $positionHtml = 'Current location';
                    $value->current = true;
                }
                else
                    $positionHtml = 'After '. $previous->title;
            }

            if($previous && isset($previous->current) && $previous->current == true)
                $current = $value->position;

            $positionOptions[$value->position] = $positionHtml;

            $previous = $value;
            $passedself = false;
        }

        $positionvalue = isset($previous) ? 'After '. $previous->title : "First";
        $positionOptions[1 + @max(array_keys($positionOptions))] = $positionvalue;

        if($current)
            unset($positionOptions[$current]);

        return $positionOptions;
    }

    public static function getPagesTableInformation()
    {
        /** @var ModelPages[] $pages */
        $pages = self::find();

        $row = [];

        foreach( $pages as $page )
        {
            $row[] = self::getPageForTable($page);
        }

        return $row;
    }

    public static function getPageForTable(ModelPages $page)
    {
        $parentTitle = null;
        if(!is_null($page->getParentId()))
        {
            $parentTitle = $page->getParent()->getTitle();
        }
        return [
            'DT_RowId' => $page->getId(),
            'id' => $page->getId(),
            'parent_id' => [
                'display' => $parentTitle,
                'sort' => $parentTitle,
                'filter' => $parentTitle,
                '_' => $page->getParentId(),
            ],
            'creator_id' => [
                'display'   => $page->getCreator()->getUsername(),
                'sort' => $page->getCreator()->getUsername(),
                'filter' => $page->getCreator()->getUsername(),
                '_' => $page->getCreatorId(),
            ],
            'title'         => $page->getTitle(),
            'title_menu'    => $page->getTitleMenu(),
            'keywords'      => $page->getKeywords(),
            'description'   => $page->getDescription(),
            'slug'          => $page->getSlug(),
            'route'          => $page->getRoute(),
            'content'       => $page->getContent(),
            'position'      => $page->getPosition(),
            'status'        => $page->getStatus(),
            'url'           => Di::getDefault()->getShared('url')->get([
                'for' => 'pages__'. ModelLanguage::getCurrentLanguage(),
                'slug' => $page->getSlug()
            ]),
            'created' => [
                'display' => self::getDateTime($page->getCreated()),
                '_'       => $page->getCreated()
            ],
            'modified' => [
                'display' => self::getDateTime($page->getModified()),
                '_' => $page->getModified()
            ]
        ];
    }

    private static function getDateTime($timestamp = null)
    {
        if(is_null($timestamp)) return null;

        if(ModelLanguage::getCurrentLanguage() == 'fa')
        {
            return Jalalian::forge($timestamp)->format('%B %d، %Y');
        }

        return date('Y-m-d H:i:s', $timestamp);
    }

    public function getWidgets($placeValue=null)
    {
        /** @var MobileDetect $device */
        $device = $this->getDI()->get('device');

        /** @var ModelWidgetPlaces $place */
        $place = ModelWidgetPlaces::findFirstByValue($placeValue);

        if (!$place)
        {
            return [];
        }

        /** @var ModelPageWidgetPlaceMap $pagePlaceMap */
        $pagePlaceMap = $place->getPageWidgetPlaceMaps([
            'conditions' => 'page_id=:page_id:',
            'bind' => [
                'page_id' => $this->getId()
            ]
        ])->getFirst();

        if (!$pagePlaceMap)
        {
            return [];
        }

        if ($device->isTablet())
        {
            /** @var ModelWidgetViewTablet[] $widgetViewDevice */
            $widgetViewDevice = $pagePlaceMap->getWidgetViewTablet([
                'order' => 'row, column'
            ]);
        }
        elseif ($device->isMobile())
        {
            /** @var ModelWidgetViewMobile[] $widgetViewDevice */
            $widgetViewDevice = $pagePlaceMap->getWidgetViewMobile([
                'order' => 'row, column'
            ]);
        }
        else
        {
            /** @var ModelWidgetViewDesktop[] $widgetViewDevice */
            $widgetViewDevice = $pagePlaceMap->getWidgetViewDesktop([
                'order' => 'row, column'
            ]);
        }

        $gridTemplateArea = [];
        $widgetinstances = [];

        foreach ($widgetViewDevice as $widgetView)
        {
            if (!isset($gridTemplateArea[$widgetView->getRow()]))
            {
                if (!$widgetView->getWidgetId())
                    $gridTemplateArea[$widgetView->getRow()] = '.';
                else
                    $gridTemplateArea[$widgetView->getRow()] = $placeValue.'-widget-'.$widgetView->getWidgetInstance()->getId();
            }
            else
            {
                if (!$widgetView->getWidgetId())
                    $gridTemplateArea[$widgetView->getRow()] .= ' .';
                else
                    $gridTemplateArea[$widgetView->getRow()] .= ' '. $placeValue.'-widget-'. $widgetView->getWidgetInstance()->getId();
            }

            if ($widgetView->getWidgetId())
            {
                $widgetinstances[$widgetView->getWidgetInstance()->getId()] = $widgetView->getWidgetInstance();
            }
        }


        return [
            'area' => str_replace('||','\'\'', str_replace('"', '\'', json_encode(implode('||', $gridTemplateArea)))),
            'widgets_instances' => $widgetinstances
        ];
    }
}