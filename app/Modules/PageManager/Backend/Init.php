<?php
namespace Modules\PageManager\Backend;


use Phalcon\Loader;
use Lib\Module\InitModule;

class Init extends InitModule
{
    public function init()
    {
        /** @var Loader $loader */
        $loader = new Loader();
        $loader->registerNamespaces([
            $this->moduleNamespace.'\Models' => $this->modulePath. 'Models/'
        ])->register();
    }
}