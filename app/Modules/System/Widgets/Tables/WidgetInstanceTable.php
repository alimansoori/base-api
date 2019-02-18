<?php
namespace Modules\System\Widgets\Tables;


use Lib\DTE\Table;
use Modules\System\PageManager\Models\WidgetInstance\ModelWidgetInstance;
use Modules\System\Widgets\Editors\WidgetManagerEditor;
use Modules\System\Widgets\Models\Widgets\ModelWidgets;
use Lib\DTE\Table\Columns\Type\ColumnId;
use Modules\System\Widgets\Tables\WidgetInstanceTable\Columns;

class WidgetInstanceTable extends Table
{
    use Columns;

    private $widget;

    public function __construct($name, ModelWidgets $widget)
    {
        parent::__construct($name);
        $this->widget = $widget;
    }

    public function init()
    {
        $this->setDom('t');

        // add bootstrap
        $this->assetsCollection->addCss( 'assets/datatables.net-bs4/css/dataTables.bootstrap4.min.css' );
        $this->assetsManager->addJs( 'assets/datatables.net-bs4/js/dataTables.bootstrap4.min.js' );

        $this->addOption( 'responsive', true );
        $this->addOption( 'direction', 'rtl' );
    }

    public function initData()
    {
        $this->setData(ModelWidgetInstance::getTableInformation($this->widget));
    }

    public function initButtons()
    {
    }

    public function initColumns()
    {
//        $this->ColumnSelectCheckbox();
//        $this->ColumnReorder();
        $this->addColumn(new ColumnId());
        $this->columnTitle();
        $this->columnWidgetId();
        $this->columnModule();
        $this->columnPreview();
    }

    public function initAjax()
    {
        $this->ajax->addData('route_id', $this->request->get('route_id'));
    }
}