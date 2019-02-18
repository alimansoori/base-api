<?php
namespace Lib\Mvc\Router;


use Lib\Translate\T;
use Modules\System\Native\Models\Language\ModelLanguage;

trait TRouterCommon
{
    public function getRoutesInLocal()
    {
        $lang = ModelLanguage::getCurrentLanguage();

        $routesLocale = [];

        /** @var Route $route */
        foreach($this->getRoutes() as $route)
        {
            if(!isset($route->getPaths()['lang']) || $route->getPaths()['lang'] !== $lang)
                continue;

            $routesLocale[] = $route;
        }
        return $routesLocale;
    }

    public function getRoutesByNameValue($local = true)
    {
        $lang = ModelLanguage::getCurrentLanguage();

        $routesLocale = [];

        /** @var Route $route */
        foreach($this->getRoutes() as $route)
        {
            if($local && (!isset($route->getPaths()['lang']) || $route->getPaths()['lang'] !== $lang))
                continue;

            $routesLocale[] = [
                'value' => $route->getName(),
                'name' => T::_(preg_replace(
                    '/^([a-z_-]+)(__[a-z]{2,3})$/',
                    '$1',
                    $route->getName()
                ))
            ];
        }
        return $routesLocale;
    }
}