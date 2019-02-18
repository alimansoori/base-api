<?php
namespace Modules\System\Widgets\Controllers;


use Lib\DTE\Editor\StandaloneEditor;
use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Mvc\Model\Options\ModelOptions;
use Lib\Translate\T;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;
use Modules\System\Widgets\Models\Widgets\ModelWidgets;
use Modules\System\Widgets\Tables\WidgetInstanceTable;

class WidgetInstanceParamsController extends AdminController
{
    public function indexAction()
    {
        $widgetInstanceId = $this->dispatcher->getParam('widget_instance_params');

        if (!$widgetInstanceId)
        {
            throw new Exception('widget instance does not exist');
        }

        /** @var ModelWidgetInstance $widgetInstance */
        $widgetInstance = ModelWidgetInstance::findFirst($widgetInstanceId);

        if (!$widgetInstance)
        {
            throw new Exception('widget instance does not exist');
        }

        $widgetNamespace = $widgetInstance->getWidget()->getNamespace();

        $editor = $widgetNamespace::setting($widgetInstance);

        if (!$editor instanceof StandaloneEditor)
        {
            throw new Exception('editor is incorrect');
        }

        $this->tag->prependTitle(T::_('widgets_manager'));

        $this->view->editor = $editor;
    }
}