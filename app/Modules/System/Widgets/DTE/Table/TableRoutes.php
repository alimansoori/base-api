<?php
namespace Modules\System\Widgets\DTE\Table;


use Lib\DTE\Table;
use Lib\DTE\Table\Columns\Column;
use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Mvc\Router\Route;

class TableRoutes extends Table
{
    public function init()
    {
        $this->setDom("tr");
    }

    public function initButtons()
    {
        // TODO: Implement initButtons() method.
    }

    public function initColumns()
    {
        $routeName = new Column('name');
        $routeName->setData('name');
        $routeName->setTitle(T::_('route_name'));
        $this->addColumn($routeName);

        //        $language = new Column('language');
        //        $language->setLabel(T::_('language_route'));
        //        $language->setData('language');
        //        $this->addColumn($language);
    }

    public function initData()
    {
        $result = [];

        /** @var Route $widget */
        foreach($this->router->getRoutes() as $route)
        {
            $routeLanguage = substr($route->getName(), strpos($route->getName(), "__") + 2);

            if(ModelLanguage::getCurrentLanguage() !== $routeLanguage)
            {
                continue;
            }

            $row = [];
            $row['DT_RowId'] = 'row_'. $route->getRouteId();
            $row['id'] = $route->getRouteId();
            $row['route_name'] = $route->getName();
            $row['name'] = T::_(
                str_replace(
                    substr($route->getName(), strpos($route->getName(), "__") + 0),
                    '',
                    $route->getName()
                )
            );

            $result[] = $row;
        }

        $this->data = $result;
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }
}