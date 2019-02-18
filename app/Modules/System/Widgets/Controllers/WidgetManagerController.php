<?php
namespace Modules\System\Widgets\Controllers;


use Lib\Mvc\Controllers\AdminController;
use Lib\Mvc\Model\Options\ModelOptions;
use Lib\Translate\T;
use Modules\System\Widgets\Tables\WidgetManagerTable;
use Phalcon\Text;

class WidgetManagerController extends AdminController
{
    public function indexAction()
    {
        $this->tag->prependTitle(T::_('widgets_manager'));
        $table = new WidgetManagerTable('widget_manager_table');
        $this->view->table = $table->process();
    }
}