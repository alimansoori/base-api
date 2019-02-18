<?php
namespace Lib\Events\Router;


use Phalcon\Events\EventInterface;
use Phalcon\Mvc\RouterInterface;

class AfterCheckRoutes
{
    public function __construct(EventInterface $event, RouterInterface $router)
    {
    }
}