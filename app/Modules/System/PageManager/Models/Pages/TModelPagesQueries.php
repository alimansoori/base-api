<?php
namespace Modules\System\PageManager\Models\Pages;


use Modules\System\Widgets\Models\Widgets\ModelWidgets;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;
use Phalcon\Mvc\Router\RouteInterface;
use Modules\System\Native\Models\Language\ModelLanguage;

trait TModelPagesQueries
{
    /**
     * Get page by slug and local language
     * @param string $slug
     * @return null|self
     */
    public static function getPageResult($slug = null)
    {
        $params = [];

        if(!$slug)
            $params['conditions'] = 'slug IS NULL AND language_iso=:lang:';
        else
        {
            $params['conditions'] = 'slug=:slug: AND language_iso=:lang:';
            $params['bind']['slug'] = $slug;
        }
        $params['bind']['lang'] = ModelLanguage::getCurrentLanguage();

        $page = self::findFirst($params);

        if($page)
            return $page;

        return null;
    }

    public function getWidgetsSortByPlaceAndPosition()
    {
        return $this->getWidgets([
            'order' => 'position, place'
        ]);
    }

    public function getWidgetsByPlaceSortByPosition($place, $iterator = false)
    {
        /** @var ModelWidgetInstance[]|null $widgets */
        $widgets = $this->getPageWidgets([
            'conditions' => 'place=:place:',
            'order' => 'position',
            'bind' => [
                'place' => $place
            ]
        ]);


        if($iterator)
            $widgets = new \ArrayIterator($widgets);

        return $widgets;
    }

    /**
     * @param RouteInterface $route
     * @return array
     */
    public static function getPagesByRoute( RouteInterface $route)
    {
        $pages = self::find([
            'columns' => "CONCAT('row_', id) as DT_RowId, id, title, title_menu, slug, parent_id",
            'conditions' => 'route_id=:route_id:',
            'bind' => [
                'route_id' => $route->getName()
            ]
        ])->toArray();

        return $pages;
    }
}