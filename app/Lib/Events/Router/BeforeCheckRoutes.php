<?php
namespace Lib\Events\Router;


use Modules\System\PageManager\Models\Routes\ModelRoutes;
use Lib\Mvc\Router;
use Phalcon\Events\EventInterface;
use Phalcon\Mvc\RouterInterface;

class BeforeCheckRoutes
{
    /**
     * BeforeCheckRoutes constructor.
     * @param EventInterface $event
     * @param RouterInterface|Router $router
     */
    public function __construct(EventInterface $event, RouterInterface $router)
    {
//        ModelRoutes::setApplicationRoutes($router);
    }
}