<?php
namespace Modules\System\Widgets\Controllers;


use Lib\Mvc\Controllers\AdminController;
use Lib\Mvc\Model\ModelTest;
use Lib\Translate\T;
use Modules\System\PageManager\Models\Pages\ModelPages;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;
use Modules\System\Widgets\Models\WidgetPlaces\ModelWidgetPlaces;
use Modules\System\Widgets\Tables\PageWidgetsManagerTable;

class PageWidgetsManagerController extends AdminController
{
    private $device;
    private $page_id;
    private $place;

    public function initialize()
    {
        parent::initialize();

        $this->validateInputs();
    }

    public function indexAction()
    {

        $this->tag->prependTitle(T::_('page_widgets_manager'));
        $table = new PageWidgetsManagerTable(
            'page_widgets_manager_table',
            $this->device,
            $this->page_id,
            $this->place
        );

        $this->view->table = $table->process();
    }

    private function validateInputs()
    {
        $device = $this->dispatcher->getParam('device');
        $page_id = $this->dispatcher->getParam('page_id');
        $place = $this->dispatcher->getParam('place');

        if (!in_array($device, [
            'desktop',
            'tablet',
            'mobile'
        ]))
        {
            dump('device incorrect');
        }

        if (!in_array($page_id, array_column(
            ModelPages::find(['columns' => 'id'])->toArray(),
            'id'
        )))
        {
            dump('page incorrect');
        }

        if (!in_array($place, array_column(
            ModelWidgetPlaces::find(['columns' => 'id'])->toArray(),
            'id'
        )))
        {
            dump('place incorrect');
        }

        $this->place = $place;
        $this->page_id = $page_id;
        $this->device = $device;
    }
}