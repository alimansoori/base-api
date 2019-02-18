<?php
namespace Lib\Events\Router;

use Phalcon\Mvc\Router\RouteInterface;
use Phalcon\Events\EventInterface;
use Phalcon\Mvc\RouterInterface;

class BeforeCheckRoute
{
    public function __construct(EventInterface $event, RouterInterface $router, RouteInterface $route)
    {
    }
}