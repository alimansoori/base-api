<?php
namespace Modules\System\Widgets\Tables;


use Lib\DTE\Table;
use Modules\System\Widgets\Editors\WidgetManagerEditor;
use Modules\System\Widgets\Models\Widgets\ModelWidgets;
use Modules\System\Widgets\Tables\WidgetManager\Columns;

class WidgetManagerTable extends Table
{
    use Columns;

    public function init()
    {
        $this->setEditor(new WidgetManagerEditor('widget_manager_editor'));
        $this->setDom('Bfrtip');

        // add bootstrap
        $this->assetsCollection->addCss( 'assets/datatables.net-bs4/css/dataTables.bootstrap4.min.css' );
        $this->assetsManager->addJs( 'assets/datatables.net-bs4/js/dataTables.bootstrap4.min.js' );

        $this->addOption( 'responsive', true );
        $this->addOption( 'direction', 'rtl' );
    }

    public function initData()
    {
        $this->setData(ModelWidgets::getTableInformation());
    }

    public function initButtons()
    {
        $this->buttonCreate();
        $this->buttonEdit();
        $this->buttonRemove();
    }

    public function initColumns()
    {
//        $this->ColumnSelectCheckbox();
//        $this->ColumnReorder();
        $this->addColumn(new Table\Columns\Type\ColumnId());
        $this->columnName();
        $this->columnModule();
    }

    public function initAjax()
    {
        $this->ajax->addData('route_id', $this->request->get('route_id'));
    }
}