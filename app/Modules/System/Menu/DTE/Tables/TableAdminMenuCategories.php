<?php
namespace Modules\System\Menu\DTE\Tables;


use Modules\System\Menu\DTE\Editors\EditorAdminMenuCategories;
use Modules\System\Menu\DTE\Tables\TableAdminMenuCategories\Buttons;
use Modules\System\Menu\DTE\Tables\TableAdminMenuCategories\Columns;
use Lib\DTE\Table;
use Modules\System\Menu\Models\AdminMenuCategory\ModelAdminMenuCategory;

class TableAdminMenuCategories extends Table
{
    use Columns;
    use Buttons;

    public function init()
    {
        $this->setEditor(new EditorAdminMenuCategories('admin_menu_categories_editor'));
        $this->setDom('Bt');
    }

    public function initButtons()
    {
        $this->btnCreate();
        $this->btnEdit();
        $this->btnRemove();
    }

    public function initColumns()
    {
        $this->columnReorder();
        $this->columnTitle();
    }

    public function initData()
    {
        $this->setData(ModelAdminMenuCategory::getTableInfo());
    }

    public function initAjax()
    {
    }
}