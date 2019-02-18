<?php
namespace Modules\System\Widgets\Models\Widgets;

use Lib\Module\ModuleManager;

trait TModelWidgetsEvents
{
    public function beforeValidationOnCreate()
    {
        parent::beforeValidationOnCreate();
        if($this->getNamespace() && !$this->getName())
        {
            if(isset(ModuleManager::getWidgetsByNamespaceName()[$this->getNamespace()]))
            {
                $this->setName(
                    ModuleManager::getWidgetsByNamespaceName()[$this->getNamespace()]
                );
            }
        }
    }
}