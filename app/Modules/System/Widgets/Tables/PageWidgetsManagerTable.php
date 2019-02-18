<?php
namespace Modules\System\Widgets\Tables;


use Lib\DTE\Table;
use Lib\Translate\T;
use Modules\System\Widgets\Editors\PageWidgetsManagerEditor;
use Modules\System\Widgets\Models\ModelPageWidgetPlaceMap;
use Modules\System\Widgets\Tables\PageWidgetsManager\Buttons;
use Modules\System\Widgets\Tables\PageWidgetsManager\Columns;

class PageWidgetsManagerTable extends Table
{
    protected $placeId;
    protected $pageId;
    protected $device;

    use Columns;
    use Buttons;

    public function __construct($name, $device, $pageId, $placeId)
    {
        parent::__construct($name);
        $this->device = $device;
        $this->pageId = $pageId;
        $this->placeId = $placeId;
    }

    public function init()
    {
        $this->setEditor(new PageWidgetsManagerEditor(
            'page_widgets_manager_editor',
            $this->device,
            $this->pageId,
            $this->placeId
        ));

        $this->setDom('Bt');
    }

    public function initButtons()
    {
        $this->btnAddRow($this->device);
        $this->btnRemove();
    }

    public function initColumns()
    {
        $this->columnsDesktop();
        $this->columnsTablet();
        $this->columnsMobile();

    }

    public function initData()
    {
        $this->setData(ModelPageWidgetPlaceMap::getTableInformation($this->device, $this->pageId, $this->placeId));
    }

    public function initAjax()
    {
    }
}