<?php
namespace Lib\Events\Router;


use Phalcon\Events\EventInterface;
use Phalcon\Mvc\Router\GroupInterface;
use Phalcon\Mvc\RouterInterface;

class BeforeMount
{
    public function __construct(EventInterface $event, RouterInterface $router, GroupInterface $group)
    {
        dump('Event BeforeMount');
    }
}