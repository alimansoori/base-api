<?php
namespace Modules\System\Widgets\Controllers;


use Lib\Exception;
use Lib\Mvc\Controllers\AdminController;
use Lib\Mvc\Model\Options\ModelOptions;
use Lib\Translate\T;
use Modules\System\Widgets\Models\Widgets\ModelWidgets;
use Modules\System\Widgets\Tables\WidgetInstanceTable;

class WidgetInstanceController extends AdminController
{
    public function indexAction()
    {
        $widgetId = $this->dispatcher->getParam('widget_id');

        if (!$widgetId)
        {
            throw new Exception('widget does not exist');
        }

        $widget = ModelWidgets::findFirst($widgetId);

        if (!$widget)
        {
            throw new Exception('widget does not exist');
        }


        $this->tag->prependTitle(T::_('widgets_manager'));
        $table = new WidgetInstanceTable('widget_instance_table', $widget);
        $this->view->table = $table->process();
    }
}