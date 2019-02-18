<?php
namespace Lib\Events\Router;


use Lib\Mvc\Router;
use Lib\Mvc\Router\Route;
use Phalcon\Events\Event;
use Phalcon\Events\EventInterface;
use Phalcon\Mvc\Router\RouteInterface;
use Phalcon\Mvc\RouterInterface;

class MatchedRoute
{
    /**
     * @param EventInterface|Event $event
     * @param RouterInterface|Router $router
     * @param RouteInterface|Route $route
     */
    public function __construct( EventInterface $event, RouterInterface $router, RouteInterface $route)
    {
    }
}