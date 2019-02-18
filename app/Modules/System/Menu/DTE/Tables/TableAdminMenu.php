<?php

namespace Modules\System\Menu\DTE\Tables;


use Lib\DTE\Table;
use Modules\System\Menu\DTE\Editors\EditorAdminMenu;
use Modules\System\Menu\DTE\Tables\TableAdminMenu\Buttons;
use Modules\System\Menu\DTE\Tables\TableAdminMenu\Columns;
use Modules\System\Menu\Models\AdminMenu\ModelAdminMenu;

class TableAdminMenu extends Table
{
    use Columns;
    use Buttons;

    public function init()
    {
        $this->addOption('ordering', false);
        $this->setEditor(new EditorAdminMenu('admin_menu_editor'));
        $this->setDom('Bfrtip');
        $this->rowGroup->setDataSrc('category_id.display');

//        dump(ModelAdminMenu::getTableInfo());
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
//        $this->columnCategory();
//        $this->columnParent();
        $this->columnLink();
        $this->columnIcon();
    }

    public function initData()
    {
        $this->setData(ModelAdminMenu::getTableInfo());
    }

    public function initAjax()
    {
        // TODO: Implement initAjax() method.
    }
}