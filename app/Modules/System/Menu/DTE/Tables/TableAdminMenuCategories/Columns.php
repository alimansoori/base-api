<?php
namespace Modules\System\Menu\DTE\Tables\TableAdminMenuCategories;


use Lib\DTE\Table\Columns\Column;
use Lib\DTE\Table\Columns\Type\ColumnReOrder;
use Lib\Translate\T;

trait Columns
{
    protected function columnReorder()
    {
        $col = new ColumnReOrder('reorder');
        $col->setEditor($this->getEditor('admin_menu_categories_editor'));
        $col->setData('position');
        $col->setTitle(T::_('row'));
        $col->setClassName('dt-center');
        $col->setWidth('10px');

        $this->addColumn($col);
    }

    protected function columnTitle()
    {
        $col = new Column('title');
        $col->setTitle(T::_('title'));
        $col->setClassName('dt-center');


        $this->addColumn($col);
    }
}