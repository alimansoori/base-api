<?php
namespace Modules\System\PageManager\DTE\Table;


use Lib\DTE\Table;
use Lib\DTE\Table\Columns\Column;
use Lib\Translate\T;
use Modules\System\PageManager\DTE\Editor\EditorPageManager;
use Modules\System\PageManager\DTE\Table\PageManager\TTablePageManager;
use Modules\System\PageManager\Editors\PageDesignForWidgetsEditor;
use Modules\System\PageManager\Models\Pages\ModelPages;
use Modules\System\PageManager\Models\Routes\ModelRoutes;

class TablePageManager extends Table
{
    use TTablePageManager;

    public function init()
    {
        $this->setEditor(new EditorPageManager('page_manager_editor'));
        $this->setEditor(new PageDesignForWidgetsEditor('page_design_for_widgets_editor'));

        $this->setDom('Brtip');

        // add bootstrap
        $this->assetsCollection->addCss( 'assets/datatables.net-bs4/css/dataTables.bootstrap4.min.css' );
        $this->assetsManager->addJs( 'assets/datatables.net-bs4/js/dataTables.bootstrap4.min.js' );

        $this->addOption( 'responsive', true );
        $this->addOption( 'direction', 'rtl' );
    }

    public function initData()
    {
        $this->setData(ModelPages::getPagesTableInformation());
    }

    public function initButtons()
    {
        $this->buttonCreate();
        $this->buttonEdit();
        $this->buttonRemove();
        $this->btnDesignPage();
    }

    public function initColumns()
    {
//        $this->ColumnSelectCheckbox();
//        $this->ColumnReorder();
        $this->addColumn(new Table\Columns\Type\ColumnId());
        $this->columnTitle();
        $this->columnTitleMenu();
        $this->columnParentId();
        $this->columnSlug();
        $this->columnRoute();
        $this->columnStatus();
        $this->columnCreator();
        $this->columnCreated();
        $this->columnPreview();
    }

    public function initAjax()
    {
        $this->ajax->addData('route_id', $this->request->get('route_id'));
    }
}