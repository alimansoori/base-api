<?php
namespace Lib\Module;


use Lib\Acl\AbstractAcl;
use Phalcon\DiInterface;

abstract class InitModule
{
    /** @var DiInterface $di */
    protected $di;
    protected $modulePath;
    protected $moduleName;
    protected $moduleNamespace; // Modules\System\PageManager

    public function __construct(DiInterface $di, $modulePath, $moduleName, $moduleNamespace)
    {
        $this->di = $di;
        $this->moduleName = $moduleName;
        $this->moduleNamespace = $moduleNamespace;
        $this->modulePath = $modulePath;

        $this->init();
    }

    abstract public function init();
}