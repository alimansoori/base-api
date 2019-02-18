<?php
namespace Modules\System\Widgets\Models\Modules;


use Lib\Module\ModuleManager;

trait Events
{
    public function beforeValidation()
    {
        if(isset(ModuleManager::getAllModules()[$this->getName()]))
        {
            $this->setPath(ModuleManager::getAllModules()[$this->getName()]['path']);
            $this->setNamespace(
                str_replace('\Module', '', ModuleManager::getAllModules()[$this->getName()]['className'])
            );
        }
    }
}