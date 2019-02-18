<?php

namespace Lib\Mvc;

use Lib\Events\Router\AfterCheckRoutes;
use Lib\Events\Router\BeforeCheckRoute;
use Lib\Events\Router\BeforeCheckRoutes;
use Lib\Events\Router\BeforeMount;
use Lib\Events\Router\MatchedRoute;
use Lib\Events\Router\NotMatchedRoute;
use Lib\Mvc\Helper\Locale;
use Lib\Mvc\Router\Route;
use Phalcon\Mvc\Router\RouteInterface;
use Lib\Mvc\Router\TRouterCommon;
use Modules\System\Native\Models\Language\ModelLanguage;
use Phalcon\Events\EventInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Mvc\Router\GroupInterface;
use Phalcon\Mvc\RouterInterface;

class Router extends \Phalcon\Mvc\Router
{
    use TRouterCommon;

    public function __construct( $defaultRoutes = true )
    {
        parent::__construct( $defaultRoutes );
        $this->_routes = [];
    }

    /**
     * Returns the route that matches the handled URI
     *
     * @return RouteInterface
     */
    public function getMatchedRoute()
    {
        return parent::getMatchedRoute();
    }

    /**
     * Returns all the routes defined in the router
     *
     * @return \Lib\Mvc\Router\RouteInterface[]
     */
    public function getRoutes()
    {
        return parent::getRoutes();
    }

    /**
     * @param $pattern
     * @param null $paths
     * @param null $httpMethods
     * @param int $position
     * @return Route
     */
    public function add( $pattern, $paths = null, $httpMethods = null, $position = \Phalcon\Mvc\Router::POSITION_LAST )
    {
        $route = new Route($pattern, $paths, $httpMethods);
        $this->attach($route, $position);

        return $route;
    }

    public function setEvents()
    {
        $eventManager = $this->getEventsManager();
        if(!$eventManager instanceof ManagerInterface)
            return false;

        $eventManager->attach('router:afterCheckRoutes', function(EventInterface $event, RouterInterface $router){
            new AfterCheckRoutes($event, $router);
        });

        $eventManager->attach('router:beforeCheckRoutes', function(EventInterface $event,RouterInterface $router){
            new BeforeCheckRoutes($event, $router);
        });

        $eventManager->attach('router:beforeCheckRoute', function(EventInterface $event, RouterInterface $router, RouteInterface $route){
            new BeforeCheckRoute($event, $router, $route);
        });

        $eventManager->attach('router:matchedRoute', function( EventInterface $event, RouterInterface $router, RouteInterface $route){
            new MatchedRoute($event, $router, $route);
        });

        $eventManager->attach('router:notMatchedRoute', function(EventInterface $event, RouterInterface $router, RouteInterface $route){
            new NotMatchedRoute($event, $router, $route);
        });

        $eventManager->attach('router:beforeMount', function(EventInterface $event, RouterInterface $router, GroupInterface $group){
            new BeforeMount($event, $router, $group);
        });
    }
}