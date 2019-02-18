<?php
namespace Lib\Module;


use Lib\Mvc\Router;
use Phalcon\DiInterface;
use Phalcon\Mvc\RouterInterface;

abstract class RoutesModule
{
    /** @var DiInterface $di */
    protected $di;
    /** @var Router $router */
    protected $router;
    protected $modulePath;
    protected $moduleName;
    protected $moduleNamespace; // Modules\System\PageManager

    public function __construct(DiInterface $di, RouterInterface $router, $modulePath, $moduleName, $moduleNamespace)
    {
        $this->di = $di;
        $this->router = $router;
        $this->moduleName = $moduleName;
        $this->moduleNamespace = $moduleNamespace;
        $this->modulePath = $modulePath;

        $this->init();
    }

    abstract public function init();
}